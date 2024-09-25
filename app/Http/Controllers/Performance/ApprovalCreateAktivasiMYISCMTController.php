<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Models\MitraManajemen;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;
use App\Models\CreateAktivasiMYISCMTModel;

use Illuminate\Http\Request;

class ApprovalCreateAktivasiMYISCMTController extends Controller
{
    public function index()
    {
        $createCreateAktivasiMYISCMT = CreateAktivasiMYISCMTModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $validasitacticalPending = ValidasiTacticalModel::where('status_validasi', 0)->count();
        $createaktivasiMyiSCMTPending = CreateAktivasiMYISCMTModel::where('status_myi', 0)->count();
        $duplicatePending = DuplicateWHModel::where('status_duplicate', 0)->count();
        $pindahPending = PindahWHModel::where('status_pindah_wh', 0)->count();
        $totalPending = $validasitacticalPending + $createaktivasiMyiSCMTPending + $duplicatePending + $pindahPending;

        $createCreateAktivasiMYISCMT = $createCreateAktivasiMYISCMT->sortByDesc('created_at');

        return view('pages/performance/approval_ca_myiscmt', [
            'createCreateAktivasiMYISCMT' => $createCreateAktivasiMYISCMT,
            'validasitacticalPending' => $validasitacticalPending,
            'createaktivasiMyiSCMTPending' => $createaktivasiMyiSCMTPending,
            'duplicatePending' => $duplicatePending,
            'pindahPending' => $pindahPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function approve(Request $request, string $id)
    {
        $createAktivasi = CreateAktivasiMYISCMTModel::find($id);

        if ($request->action === 'done') {
            $types = explode('/', $createAktivasi->myiscmt_type);

            CreateAktivasiMYISCMTModel::where('id', $id)->update(['status_myi' => 1, 'komentar' => $request->komentar]);

            // Update status_myi if contains create-myi or aktivasi-myi
            if (in_array('create-myi', $types) || in_array('aktivasi-myi', $types)) {
                MitraManajemen::where('user_id', $createAktivasi->user_id)->update(['status_myi' => 1]);
            }
            // Update status_scmt if contains create-scmt or aktivasi-scmt
            if (in_array('create-scmt', $types) || in_array('aktivasi-scmt', $types)) {
                MitraManajemen::where('user_id', $createAktivasi->user_id)->update(['status_scmt' => 1]);
            }

            return back()->with('success', 'Berhasil Approve create/aktivasi MYI-SCMT.');
        } elseif ($request->action === 'reject') {
            $types = explode('/', $createAktivasi->myiscmt_type);

            // Tetap menggunakan komentar yang diberikan oleh pengguna
            CreateAktivasiMYISCMTModel::where('id', $id)->update(['status_myi' => 2, 'komentar' => $request->komentar]);

            // Update status_myi if contains create-myi or aktivasi-myi
            if (in_array('create-myi', $types) || in_array('aktivasi-myi', $types)) {
                MitraManajemen::where('user_id', $createAktivasi->user_id)->update(['status_myi' => 2]);
            }
            // Update status_scmt if contains create-scmt or aktivasi-scmt
            if (in_array('create-scmt', $types) || in_array('aktivasi-scmt', $types)) {
                MitraManajemen::where('user_id', $createAktivasi->user_id)->update(['status_scmt' => 2]);
            }

            return back()->with('error', 'Create/Aktivasi MYI-SCMT Ditolak.');
        }elseif ($request->action === 'approve') {
            $types = explode('/', $createAktivasi->myiscmt_type);
            
            CreateAktivasiMYISCMTModel::where('id', $id)->update(['status_myi' => 3, 'komentar' => $request->komentar]);

            // Update status_myi if contains create-myi or aktivasi-myi
            if (in_array('create-myi', $types) || in_array('aktivasi-myi', $types)) {
                MitraManajemen::where('user_id', $createAktivasi->user_id)->update(['status_myi' => 3]);
            }
            // Update status_scmt if contains create-scmt or aktivasi-scmt
            if (in_array('create-scmt', $types) || in_array('aktivasi-scmt', $types)) {
                MitraManajemen::where('user_id', $createAktivasi->user_id)->update(['status_scmt' => 3]);
            }

            return back()->with('success', 'MYI-SCMT NDE Approved.');
        }
    }

}
