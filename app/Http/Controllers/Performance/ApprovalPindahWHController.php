<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Models\MitraManajemen;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;
use App\Models\CreateAktivasiMYISCMTModel;
use Illuminate\Http\Request;

class ApprovalPindahWHController extends Controller
{
    public function index()
    {
        $pindahWH = PindahWHModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $validasitacticalPending = ValidasiTacticalModel::where('status_validasi', 0)->count();
        $createaktivasiMyiSCMTPending = CreateAktivasiMYISCMTModel::where('status_myi', 0)->count();
        $duplicatePending = DuplicateWHModel::where('status_duplicate', 0)->count();
        $pindahPending = PindahWHModel::where('status_pindah_wh', 0)->count();
        $totalPending = $validasitacticalPending + $createaktivasiMyiSCMTPending + $duplicatePending + $pindahPending;

        $pindahWH = $pindahWH->sortByDesc('created_at');

        return view('pages/performance/approval_pindah_wh', [
            'pindahWH' => $pindahWH,
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
            PindahWHModel::where('id', $id)->update(['status_pindah_wh' => 1, 'komentar' => $request->komentar]);

            // Retrieve the pindahWH record to get the wh_tujuan value
            $pindahWH = PindahWHModel::find($id);

            // Update the sto field in the mitra_manajemen table with the sto_tujuan value from the pindah_wh table
            MitraManajemen::where('user_id', $pindahWH->user_id)->update(['sto' => $pindahWH->sto_tujuan]);
            // Update the wh field in the mitra_manajemen table with the wh_tujuan value from the pindah_wh table
            MitraManajemen::where('user_id', $pindahWH->user_id)->update(['wh' => $pindahWH->kode_wh_tujuan]);

            return back()->with('success', 'Berhasil Pindah WH.');
        } elseif ($request->action === 'reject') {
            // Tetap menggunakan komentar yang diberikan oleh pengguna
            PindahWHModel::where('id', $id)->update(['status_pindah_wh' => 2, 'komentar' => $request->komentar]);

            return back()->with('error', 'Pindah WH Ditolak.');
        }
    }

}
