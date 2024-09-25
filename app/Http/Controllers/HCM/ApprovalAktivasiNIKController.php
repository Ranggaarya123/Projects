<?php

namespace App\Http\Controllers\HCM;

use App\Http\Controllers\Controller;
use App\Models\AktivasiNikModel;
use App\Models\NonAktifNikModel;
use App\Models\MutasiModel;
use App\Models\CreateMitraModel;
use App\Models\MitraManajemen;
use Illuminate\Http\Request;

class ApprovalAktivasiNIKController extends Controller
{
    public function index()
    {
        $aktivasiNik = AktivasiNikModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

        $aktivasiNik = $aktivasiNik->sortByDesc('created_at');

        return view('pages/hcm/approval_aktivasi_nik', [
            'aktivasiNik' => $aktivasiNik,
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function approve(Request $request, string $id)
    {
        if ($request->action === 'approve') {
            AktivasiNikModel::where('id', $id)->update(['status_aktivasi_nik' => 1, 'komentar' => $request->komentar]);
            // Update status_aktivasi_nik pada tabel users
            $aktivasiNik = AktivasiNikModel::find($id);
            MitraManajemen::where('user_id', $aktivasiNik->user_id)->update(['status_aktivasi_nik' => 1]);
            // Update status_labor pada tabel users
            MitraManajemen::where('user_id', $aktivasiNik->user_id)->update(['status_labor' => 1]);

            return back()->with('success', 'Berhasil aktivasi NIK.');
        } elseif ($request->action === 'reject') {
            // Tetap menggunakan komentar yang diberikan oleh pengguna
            AktivasiNikModel::where('id', $id)->update(['status_aktivasi_nik' => 2, 'komentar' => $request->komentar]);

            return back()->with('error', 'Aktivasi NIK ditolak.');
        }
    }

}
