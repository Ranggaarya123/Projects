<?php

namespace App\Http\Controllers\HCM;

use App\Http\Controllers\Controller;
use App\Models\MitraManajemen;
use App\Models\AktivasiNikModel;
use App\Models\NonAktifNikModel;
use App\Models\MutasiModel;
use App\Models\CreateMitraModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

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

        return view('pages/hcm/dashboard', [
            'createMitraManajemen' => $createMitraManajemen,
            'statistikMitra' => $statistikMitra,
            'aktivasiNik' => $aktivasiNik,
            'nonaktifNik' => $nonaktifNik,
            'aktivasiData' => $aktivasiData,
            'nonaktifData' => $nonaktifData,
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
            'statistikAlokasi'=> $statistikAlokasi,
            'alokasiList'=> $alokasiList,
            
        ]);
    }

    // Edit method
    public function edit($id)
    {
        // Hitung jumlah pengajuan yang belum di-approve
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

        $mitraManajemen = MitraManajemen::findOrFail($id);
        return view('mitra-manajemen.edit-hcm',compact('mitraManajemen'),[
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }

    // Update method
    public function update(Request $request, $id)
    {
        $mitraManajemen = MitraManajemen::findOrFail($id);
        $mitraManajemen->update($request->all());
        return redirect()->route('dashboardHCM')->with('success', 'Data updated successfully');
    }

    // Delete method
    public function destroy($id)
    {
        $mitraManajemen = MitraManajemen::findOrFail($id);
        $mitraManajemen->delete();
        return redirect()->route('dashboardHCM')->with('success', 'Data deleted successfully');
    }

    // Add Method
    public function create()
    {
         // Hitung jumlah pengajuan yang belum di-approve
         $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
         $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
         $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
         $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
         $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

        return view('mitra-manajemen.create-hcm',[
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function store(Request $request)
    {
        $status_values = [
            'OK' => 1,
            'NOK' => 2,
            'Approved' => 3
        ];

        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'witel' => 'required|string|max:255',
            'alokasi' => 'required|string|max:255',
            'mitra' => 'required|string|max:255',
            'craft' => 'required|string|max:255',
            'sto' => 'required|string|max:255',
            'wh' => 'required|string|max:255',
            'status_aktivasi_nik' => 'required|string',
            'status_brevet' => 'required|string',
            'status_tactical' => 'required|string',
            'status_labor' => 'required|string',
            'status_myi' => 'required|string',
            'status_scmt' => 'required|string',
        ]);

        $validatedData['status_aktivasi_nik'] = $status_values[$request->input('status_aktivasi_nik')] ?? 0;
        $validatedData['status_brevet'] = $status_values[$request->input('status_brevet')] ?? 0;
        $validatedData['status_tactical'] = $status_values[$request->input('status_tactical')] ?? 0;
        $validatedData['status_labor'] = $status_values[$request->input('status_labor')] ?? 0;
        $validatedData['status_myi'] = $status_values[$request->input('status_myi')] ?? 0;
        $validatedData['status_scmt'] = $status_values[$request->input('status_scmt')] ?? 0;

        MitraManajemen::create($validatedData);

        return redirect()->route('dashboardHCM')->with('success', 'Data added successfully');
    }

    public function showUploadForm()
    {
        // Hitung jumlah pengajuan yang belum di-approve
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

        return view('mitra-manajemen.import-excel-hcm', [
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();
    
        $rows = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
    
            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
            $rows[] = $rowData;
        }
    
        $status_values = [
            'OK' => 1,
            'NOK' => 2,
            'Approved' => 3
        ];
    
        $existingUserIds = MitraManajemen::pluck('user_id')->toArray();
        $duplicateUserIds = [];
    
        foreach ($rows as $key => $row) {
            // Skip header row
            if ($key === 0) {
                continue;
            }
    
            $userId = $row[1];
    
            if (in_array($userId, $existingUserIds)) {
                $duplicateUserIds[] = $userId;
                continue;
            }
    
            MitraManajemen::create([
                'username' => $row[0],
                'user_id' => $userId,
                'witel' => $row[2],
                'alokasi' => $row[3],
                'mitra' => $row[4],
                'craft' => $row[5],
                'sto' => $row[6],
                'wh' => $row[7],
                'status_aktivasi_nik' => $status_values[$row[8]] ?? 0,
                'status_brevet' => $status_values[$row[9]] ?? 0,
                'status_tactical' => $status_values[$row[10]] ?? 0,
                'status_labor' => $status_values[$row[11]] ?? 0,
                'status_myi' => $status_values[$row[12]] ?? 0,
                'status_scmt' => $status_values[$row[13]] ?? 0,
            ]);
        }
    
        // Redirect dengan notifikasi tentang user_id yang duplikat
        if (!empty($duplicateUserIds)) {
            return redirect()->route('dashboardHCM')->with('warning', 'Data imported with some duplicate user_ids: ' . implode(', ', $duplicateUserIds));
        }
    
        return redirect()->route('dashboardHCM')->with('success', 'File imported successfully.');
    }
}
