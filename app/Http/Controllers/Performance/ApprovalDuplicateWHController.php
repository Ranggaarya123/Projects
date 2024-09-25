<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Models\MitraManajemen;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;
use App\Models\CreateAktivasiMYISCMTModel;
use Illuminate\Http\Request;

class ApprovalDuplicateWHController extends Controller
{
    public function index()
    {
        $duplicateWH = DuplicateWHModel::with('user')->get();

       // Hitung jumlah pengajuan yang belum di-approve
       $validasitacticalPending = ValidasiTacticalModel::where('status_validasi', 0)->count();
       $createaktivasiMyiSCMTPending = CreateAktivasiMYISCMTModel::where('status_myi', 0)->count();
       $duplicatePending = DuplicateWHModel::where('status_duplicate', 0)->count();
       $pindahPending = PindahWHModel::where('status_pindah_wh', 0)->count();
       $totalPending = $validasitacticalPending + $createaktivasiMyiSCMTPending + $duplicatePending + $pindahPending;

       $duplicateWH = $duplicateWH->sortByDesc('created_at');

        return view('pages/performance/approval_duplicate_wh', [
            'duplicateWH' => $duplicateWH,
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
            DuplicateWHModel::where('id', $id)->update(['status_duplicate' => 1, 'komentar' => $request->komentar]);

            // Retrieve the duplicateWH record to get the user_id and kode_wh
            $duplicateWH = DuplicateWHModel::find($id);

            // Retrieve the existing mitraManajemen record
            $mitraManajemen = MitraManajemen::where('user_id', $duplicateWH->user_id)->first();

            if ($mitraManajemen) {
                // Concatenate the existing sto with the new sto
                $newSto = $mitraManajemen->sto . ', ' . $duplicateWH->sto;
                // Concatenate the existing wh with the new kode_wh
                $newWh = $mitraManajemen->wh . ', ' . $duplicateWH->kode_wh;

                // Update the sto field in the mitra_manajemen table
                $mitraManajemen->update(['sto' => $newSto]);
                // Update the wh field in the mitra_manajemen table
                $mitraManajemen->update(['wh' => $newWh]);
            }

            return back()->with('success', 'Berhasil Duplicate WH.');
        } elseif ($request->action === 'reject') {
            // Tetap menggunakan komentar yang diberikan oleh pengguna
            DuplicateWHModel::where('id', $id)->update(['status_duplicate' => 2, 'komentar' => $request->komentar]);

            return back()->with('error', 'Duplicate WH ditolak.');
        }
    }

}
