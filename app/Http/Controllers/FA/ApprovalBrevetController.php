<?php

namespace App\Http\Controllers\FA;

use App\Http\Controllers\Controller;
use App\Models\BrevetModel;
use App\Models\User;
use App\Models\MitraManajemen;
use Illuminate\Http\Request;

class ApprovalBrevetController extends Controller
{
    public function index()
    {
        $createBrevet = BrevetModel::with('user')->get();

        // Hitung jumlah pengajuan yang belum di-approve
        $brevetPending = BrevetModel::where('status_brevet', 0)->count();
        $totalPending = $brevetPending;

        $createBrevet = $createBrevet->sortByDesc('created_at');

        return view('pages/fa/approval_brevet', [
            'createBrevet' => $createBrevet,
            'brevetPending' => $brevetPending,
            'totalPending' => $totalPending,
        ]);
    }

    public function approve(Request $request, string $id)
    {
        if ($request->action === 'done') {
            BrevetModel::where('id', $id)->update(['status_brevet' => 1, 'keterangan' => $request->keterangan]);

            // Update status_brevet pada tabel users
            $createBrevet = BrevetModel::find($id);
            MitraManajemen::where('user_id', $createBrevet->user_id)->update(['status_brevet' => 1]);

            return back()->with('success', 'Brevet Done.');
        } elseif ($request->action === 'reject') {
            BrevetModel::where('id', $id)->update(['status_brevet' => 2, 'keterangan' => $request->keterangan]);

            // Update status_brevet pada tabel users
            $createBrevet = BrevetModel::find($id);
            MitraManajemen::where('user_id', $createBrevet->user_id)->update(['status_brevet' => 2]);

            return back()->with('error', 'Brevet ditolak.');
        } elseif ($request->action === 'approve') {
            BrevetModel::where('id', $id)->update(['status_brevet' => 3, 'keterangan' => $request->keterangan]);

            // Update status_brevet pada tabel users
            $createBrevet = BrevetModel::find($id);
            MitraManajemen::where('user_id', $createBrevet->user_id)->update(['status_brevet' => 3]);

            return back()->with('success', 'Brevet Approved.');
        }
    }
}
