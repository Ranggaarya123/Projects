<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Models\MitraManajemen;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;
use App\Models\CreateAktivasiMYISCMTModel;
use Illuminate\Http\Request;

class ApprovalValidasiTacticalController extends Controller
{
    public function index()
    {
        $validasiTactical = ValidasiTacticalModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $validasitacticalPending = ValidasiTacticalModel::where('status_validasi', 0)->count();
        $createaktivasiMyiSCMTPending = CreateAktivasiMYISCMTModel::where('status_myi', 0)->count();
        $duplicatePending = DuplicateWHModel::where('status_duplicate', 0)->count();
        $pindahPending = PindahWHModel::where('status_pindah_wh', 0)->count();
        $totalPending = $validasitacticalPending + $createaktivasiMyiSCMTPending + $duplicatePending + $pindahPending;

        $validasiTactical = $validasiTactical->sortByDesc('created_at');

        return view('pages/performance/approval_validasi_tactical', [
            'validasiTactical' => $validasiTactical,
            'validasitacticalPending' => $validasitacticalPending,
            'createaktivasiMyiSCMTPending' => $createaktivasiMyiSCMTPending,
            'duplicatePending' => $duplicatePending,
            'pindahPending' => $pindahPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function approve(Request $request, string $id)
    {
        if ($request->action === 'approve') {
            ValidasiTacticalModel::where('id', $id)->update(['status_validasi' => 1, 'komentar' => $request->komentar]);
            // Update status_tactical pada pada tabel Mitra Manajemen
            $validasiTactical = ValidasiTacticalModel::find($id);
            MitraManajemen::where('user_id', $validasiTactical->user_id)->update(['status_tactical' => 1]);

            return back()->with('success', 'Berhasil Aktivasi NIK.');
        } elseif ($request->action === 'reject') {
            // Tetap menggunakan komentar yang diberikan oleh pengguna
            ValidasiTacticalModel::where('id', $id)->update(['status_validasi' => 2, 'komentar' => $request->komentar]);
            // Update status_tactical pada tabel Mitra Manajemen
            $validasiTactical = ValidasiTacticalModel::find($id);
            MitraManajemen::where('user_id', $validasiTactical->user_id)->update(['status_tactical' => 2]);

            return back()->with('error', 'Validasi Tactical Ditolak.');
        }
    }

}
