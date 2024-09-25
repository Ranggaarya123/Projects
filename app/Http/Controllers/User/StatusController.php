<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreateAktivasiMYISCMTModel;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;

class StatusController extends Controller
{
    public function index()
    {
        $types = [
            'Create/Aktivasi MYI-SCMT',
            'Validasi Tactical',
            'Duplicate WH',
            'Pindah WH'
        ];

        // Ambil tipe yang dipilih dari query string, default semua tipe jika tidak ada yang dipilih
        $selectedTypes = request()->query('type', $types);

        $createAktivasiMYISCMT = CreateAktivasiMYISCMTModel::all();
        $validasiTactical = ValidasiTacticalModel::all();
        $duplicateWH = DuplicateWHModel::all();
        $pindahWH = PindahWHModel::all();

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

        $allStatuses = $allStatuses->sortByDesc('created_at');

        return view('pages.user.status', [
            'statuses' => $allStatuses,
            'types' => $types,
        ]);
    }
}
