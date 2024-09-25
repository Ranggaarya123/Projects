<?php

namespace App\Http\Controllers\HCM;

use App\Http\Controllers\Controller;
use App\Models\BrevetModel;
use App\Models\AktivasiNikModel;
use App\Models\NonAktifNikModel;
use App\Models\MutasiModel;
use App\Models\CreateMitraModel;
use Illuminate\Http\Request;

class StatusBrevetController extends Controller
{
    public function index(Request $request)
    {
        $query = BrevetModel::query();

        // Check if a search term is provided
        if ($request->has('search') && $request->search != '') {
            $query->where('user_id', 'like', '%' . $request->search . '%');
        }

        $createBrevet = $query->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $aktivasiNikPending = AktivasiNikModel::where('status_aktivasi_nik', 0)->count();
        $nonaktifNikPending = NonAktifNikModel::where('status_aktivasi_nik', 0)->count();
        $mutasiNikPending = MutasiModel::where('status_mutasi', 0)->count();
        $createMitraPending = CreateMitraModel::where('status_aktivasi', 0)->count();
        $totalPending = $aktivasiNikPending + $nonaktifNikPending + $mutasiNikPending + $createMitraPending;
        
        $createBrevet = $createBrevet->sortByDesc('created_at');
        
        return view('pages/hcm/status_brevet', [
            'createBrevet' => $createBrevet, 'search' => $request->search,
            'aktivasiNikPending' => $aktivasiNikPending,
            'nonaktifNikPending' => $nonaktifNikPending,
            'mutasiNikPending' => $mutasiNikPending,
            'createMitraPending' => $createMitraPending,
            'totalPending' => $totalPending,
        ]);
    }
}
