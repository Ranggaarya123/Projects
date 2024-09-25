<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;
use App\Models\CreateAktivasiMYISCMTModel;
use App\Models\ValidasiTacticalModel;
use App\Models\DuplicateWHModel;
use App\Models\PindahWHModel;
use App\Models\AktivasiNikModel;
use App\Models\NonaktifNikModel;
use App\Models\BrevetModel;
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
        $validasitacticalPending = ValidasiTacticalModel::where('status_validasi', 0)->count();
        $createaktivasiMyiSCMTPending = CreateAktivasiMYISCMTModel::where('status_myi', 0)->count();
        $duplicatePending = DuplicateWHModel::where('status_duplicate', 0)->count();
        $pindahPending = PindahWHModel::where('status_pindah_wh', 0)->count();
        $totalPending = $validasitacticalPending + $createaktivasiMyiSCMTPending + $duplicatePending + $pindahPending;

        $createBrevet = $createBrevet->sortByDesc('created_at');
        
        return view('pages/performance/status_brevet', [
            'createBrevet' => $createBrevet, 'search' => $request->search,
            'validasitacticalPending' => $validasitacticalPending,
            'createaktivasiMyiSCMTPending' => $createaktivasiMyiSCMTPending,
            'duplicatePending' => $duplicatePending,
            'pindahPending' => $pindahPending,
            'totalPending' => $totalPending,
        ]);
    }
}
