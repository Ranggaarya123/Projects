<?php

namespace App\Http\Controllers\FA;

use App\Http\Controllers\Controller;
use App\Models\MitraManajemen;
use App\Models\AktivasiNikModel;
use App\Models\NonAktifNikModel;
use App\Models\BrevetModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $createMitraManajemen = MitraManajemen::with('user')->get();

        // Ambil tanggal dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Hitung statistik mitra
        $statistikMitra = MitraManajemen::select('mitra')
            ->selectRaw('COUNT(CASE WHEN status_aktivasi_nik = 1 THEN 1 END) as nik_ok')
            ->selectRaw('COUNT(CASE WHEN status_aktivasi_nik = 2 THEN 1 END) as nik_nok')
            ->selectRaw('COUNT(*) as total_nik')
            ->groupBy('mitra')
            ->get();

        // Hitung jumlah aktivasi dan nonaktif NIK dengan filter tanggal
        $aktivasiNikQuery = AktivasiNikModel::where('status_aktivasi_nik', 1);
        $nonaktifNikQuery = NonAktifNikModel::where('status_aktivasi_nik', 1);

        if ($startDate) {
            $aktivasiNikQuery->where('updated_at', '>=', $startDate);
            $nonaktifNikQuery->where('updated_at', '>=', $startDate);
        }
        if ($endDate) {
            $aktivasiNikQuery->where('updated_at', '<=', $endDate);
            $nonaktifNikQuery->where('updated_at', '<=', $endDate);
        }

        $aktivasiNik = $aktivasiNikQuery->count();
        $nonaktifNik = $nonaktifNikQuery->count();

        // Data untuk bar chart
        $mitraNames = MitraManajemen::pluck('mitra')->toArray(); // Ambil semua nama mitra

        // Data untuk bar chart dengan filter tanggal
        $aktivasiData = MitraManajemen::leftJoin('aktivasi_nik', 'mitra_manajemen.user_id', '=', 'aktivasi_nik.user_id')
            ->where('aktivasi_nik.status_aktivasi_nik', 1)
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('aktivasi_nik.updated_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('aktivasi_nik.updated_at', '<=', $endDate);
            })
            ->select('mitra_manajemen.mitra', \DB::raw('COUNT(aktivasi_nik.user_id) as total'))
            ->groupBy('mitra_manajemen.mitra')
            ->get()
            ->pluck('total', 'mitra')
            ->toArray();

        $nonaktifData = MitraManajemen::leftJoin('nonaktif_nik', 'mitra_manajemen.user_id', '=', 'nonaktif_nik.user_id')
            ->where('nonaktif_nik.status_aktivasi_nik', 1)
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('nonaktif_nik.updated_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('nonaktif_nik.updated_at', '<=', $endDate);
            })
            ->select('mitra_manajemen.mitra', \DB::raw('COUNT(nonaktif_nik.user_id) as total'))
            ->groupBy('mitra_manajemen.mitra')
            ->get()
            ->pluck('total', 'mitra')
            ->toArray();

        // Menambahkan mitra yang tidak ada transaksi dengan nilai 0
        $aktivasiData = array_merge(array_fill_keys($mitraNames, 0), $aktivasiData);
        $nonaktifData = array_merge(array_fill_keys($mitraNames, 0), $nonaktifData);

        // Hitung jumlah pengajuan yang belum di-approve
        $brevetPending = BrevetModel::where('status_brevet', 0)->count();
        $totalPending = $brevetPending;

        // Mengambil data mitra dan alokasi
        $mitraData = MitraManajemen::select('mitra', 'alokasi')
                                    ->get()
                                    ->groupBy('mitra');

        // Mengidentifikasi alokasi unik
        $alokasiList = MitraManajemen::select('alokasi')
                                    ->distinct()
                                    ->pluck('alokasi');

        // Menyiapkan data untuk tabel
        $statistikAlokasi = [];

        foreach ($mitraData as $namaMitra => $data) {
            $alokasiCount = [];
            foreach ($alokasiList as $alokasi) {
                $alokasiCount[$alokasi] = $data->where('alokasi', $alokasi)->count();
            }
            $statistikAlokasi[] = [
                'mitra' => $namaMitra,
                'alokasi' => $alokasiCount,
            ];
        }

        return view('pages/fa/dashboard', [
            'createMitraManajemen' => $createMitraManajemen,
            'brevetPending' => $brevetPending,
            'totalPending' => $totalPending,
            'statistikAlokasi'=> $statistikAlokasi,
            'alokasiList'=> $alokasiList,
            'statistikMitra' => $statistikMitra,
            'aktivasiNik' => $aktivasiNik,
            'nonaktifNik' => $nonaktifNik,
            'aktivasiData' => $aktivasiData,
            'nonaktifData' => $nonaktifData,
        ]);
    }
}
