<?php

namespace App\Http\Controllers\HCM;

use App\Http\Controllers\Controller;
use App\Models\AktivasiNikModel;
use App\Models\NonAktifNikModel;
use App\Models\MutasiModel;
use App\Models\CreateMitraModel;
use Illuminate\Http\Request;

class ApprovalCreateMitraController extends Controller
{
    public function index()
    {
        $createMitra = CreateMitraModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;

        $createMitra = $createMitra->sortByDesc('created_at');

        return view('pages/hcm/approval_create_mitra', [
            'createMitra' => $createMitra,
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function approve(Request $request, string $id)
    {
        $createMitra = CreateMitraModel::findOrFail($id);
        if ($request->action === 'approve') {
            $createMitra->status_aktivasi = 1;
            $createMitra->komentar = $request->komentar;
            $createMitra->save();
            return back()->with('success', 'Create NIK Baru Berhasil.');
        } elseif ($request->action === 'reject') {
            $createMitra->status_aktivasi = 2;
            $createMitra->komentar = $request->komentar;
            $createMitra->save();
            return back()->with('error', 'Create NIK Baru Ditolak.');
        }
        return redirect()->back();
    }
}
