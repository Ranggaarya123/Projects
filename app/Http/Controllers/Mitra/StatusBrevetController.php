<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\BrevetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StatusBrevetController extends Controller
{
    public function index()
    {
        // Ambil semua data BrevetModel
        $query = BrevetModel::query();

        $createBrevet = $query->get();

        $createBrevet = $createBrevet->sortByDesc('created_at');

        return view('pages/mitra/status_brevet', ['createBrevet' => $createBrevet]);
    }

    public function uploadSertifikat(Request $request, $id)
    {
        // Validasi file yang diupload
        $request->validate([
            'upload_sertifikat' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $brevet = BrevetModel::findOrFail($id);

        // Cek apakah status_brevet adalah 1 sebelum mengizinkan upload
        if ($brevet->status_brevet !== 1) {
            return redirect()->back()->withErrors('Status Brevet tidak sesuai untuk upload sertifikat.');
        }

        // Handle file upload
        $filePath = $request->file('upload_sertifikat')->store('upload_sertifikat', 'public');

        // Update record dengan path file
        $brevet->update([
            'upload_sertifikat' => $filePath
        ]);

        return redirect()->to('/mitra/status/status_brevet')->with('success', 'Berhasil Upload Sertifikat');
    }
}
