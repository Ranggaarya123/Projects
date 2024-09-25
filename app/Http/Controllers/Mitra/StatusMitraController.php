<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\CreateAktivasiMYISCMTModel;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;
use App\Models\AktivasiNikModel;
use App\Models\NonaktifNikModel;
use App\Models\BrevetModel;
use App\Models\MutasiModel;
use Illuminate\Http\Request;

class StatusMitraController extends Controller
{
    public function index()
    {
        $types = [
            'Create/Aktivasi MYI-SCMT',
            'Validasi Tactical',
            'Duplicate WH',
            'Pindah WH',
            'Aktivasi NIK',
            'Non Aktif NIK',
            'Pengajuan Brevet',
            'Mutasi'
        ];

        $selectedTypes = request()->query('type', $types);

        $createAktivasiMYISCMT = CreateAktivasiMYISCMTModel::all();
        $validasiTactical = ValidasiTacticalModel::all();
        $duplicateWH = DuplicateWHModel::all();
        $pindahWH = PindahWHModel::all();
        $aktivasiNik = AktivasiNikModel::all();
        $nonaktifNik = NonaktifNikModel::all();
        $brevet = BrevetModel::all();
        $mutasi = MutasiModel::all();

        $allStatuses = collect();

        if (in_array('Create/Aktivasi MYI-SCMT', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($createAktivasiMYISCMT->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => $item->myiscmt_type,
                    'status' => $item->status_myi == 1 ? 'Done' : ($item->status_myi == 2 ? 'Reject' : ($item->status_myi == 3 ? 'Done NDE' : 'Review')),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Validasi Tactical', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($validasiTactical->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => 'Validasi Tactical',
                    'status' => $item->status_validasi == 1 ? 'Done' : ($item->status_validasi == 2 ? 'Reject' : 'Review'),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Duplicate WH', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($duplicateWH->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => 'Duplicate WH',
                    'status' => $item->status_duplicate == 1 ? 'Done' : ($item->status_duplicate == 2 ? 'Reject' : 'Review'),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Pindah WH', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($pindahWH->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => 'Pindah WH',
                    'status' => $item->status_pindah_wh == 1 ? 'Done' : ($item->status_pindah_wh == 2 ? 'Reject' : 'Review'),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Aktivasi NIK', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($aktivasiNik->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => 'Aktivasi NIK',
                    'status' => $item->status_aktivasi_nik == 1 ? 'Done' : ($item->status_aktivasi_nik == 2 ? 'Reject' : 'Review'),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Non Aktif NIK', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($nonaktifNik->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => 'Non Aktif NIK',
                    'status' => $item->status_aktivasi_nik == 1 ? 'Done' : ($item->status_aktivasi_nik == 2 ? 'Reject' : 'Review'),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Pengajuan Brevet', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($brevet->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => 'Pengajuan Brevet',
                    'status' => $item->status_brevet == 1 ? 'Done' : ($item->status_brevet == 2 ? 'Reject' : ($item->status_brevet == 3 ? 'Approved' : 'Review')),
                    'keterangan' => $item->keterangan,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        if (in_array('Mutasi', $selectedTypes)) {
            $allStatuses = $allStatuses->merge($mutasi->map(function($item) {
                return [
                    'nik' => $item->user_id,
                    'type' => $item->mutasi_type,
                    'status' => $item->status_mutasi == 1 ? 'Done' : ($item->status_mutasi == 2 ? 'Reject' : 'Review'),
                    'keterangan' => $item->komentar,
                    'created_at' => $item->created_at,
                ];
            }));
        }

        $allStatuses = $allStatuses->sortByDesc('created_at');

        return view('pages.mitra.status', [
            'statuses' => $allStatuses,
            'types' => $types,
        ]);
    }
}
