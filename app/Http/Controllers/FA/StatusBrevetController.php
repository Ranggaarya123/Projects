<?php

namespace App\Http\Controllers\FA;

use App\Http\Controllers\Controller;
use App\Models\BrevetModel;
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
        $brevetPending = BrevetModel::where('status_brevet', 0)->count();
        $totalPending = $brevetPending;

        $createBrevet = $createBrevet->sortByDesc('created_at');
        
        return view('pages/fa/status_brevet', [
            'createBrevet' => $createBrevet, 'search' => $request->search,
            'brevetPending' => $brevetPending,
            'totalPending' => $totalPending,
        ]);
    }
}
