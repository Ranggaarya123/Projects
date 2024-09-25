<?php

namespace App\Http\Controllers\HCM;

use App\Http\Controllers\Controller;
use App\Models\AktivasiNikModel;
use App\Models\NonAktifNikModel;
use App\Models\MutasiModel;
use App\Models\CreateMitraModel;
use Illuminate\Http\Request;

class ApprovalMutasiController extends Controller
{
    public function index()
    {
        $mutasis = MutasiModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

        $mutasis = $mutasis->sortByDesc('created_at');

        return view('pages/hcm/approval_mutasi', [
            'mutasis' => $mutasis,
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function approve(Request $request, string $id)
    {
        $mutasi = MutasiModel::findOrFail($id);
        if ($request->action === 'approve') {
            $mutasi->status_mutasi = 1;
            $mutasi->komentar = $request->komentar;
            $mutasi->save();
            return back()->with('success', 'Mutasi Berhasil.');
        } elseif ($request->action === 'reject') {
            $mutasi->status_mutasi = 2;
            $mutasi->komentar = $request->komentar;
            $mutasi->save();
            return back()->with('error', 'Mutasi Ditolak.');
        }
        return redirect()->back();
    }
}
