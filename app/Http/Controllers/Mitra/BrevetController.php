<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\BrevetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrevetController extends Controller
{
    public function index () {
        return view('pages/mitra/brevet');
    }

    public function store (Request $request) {
        if ($request->hasFile('sertifikat_brevet')) {
            $data = [
                'user_id' => $request->input('user_id'),
                'nama' => $request->input('nama'),
                'mitra' => $request->input('mitra'),
                'brevet' => $request->input('brevet'),
            ];
            $file = $request->file('surat_keterangan_aktif');
            $filePath = $file->store('surat_keterangan_aktif', 'public');
            $data['surat_keterangan_aktif'] = $filePath;

            $file = $request->file('bpjs');
            $filePath = $file->store('bpjs', 'public');
            $data['bpjs'] = $filePath;

            $file = $request->file('sertifikat_brevet');
            $filePath = $file->store('sertifikat_brevet', 'public');
            $data['sertifikat_brevet'] = $filePath;

            BrevetModel::createBrevet($data);

            return redirect()->to('/mitra/brevet')->with('success', 'Upload Pengajuan Brevet.');
        } else {
            return redirect()->back()->with('error', 'File sertifikat brevet harus diunggah.');
        }
    }
}
