<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\NonAktifNikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonAktifNIKController extends Controller
{
    public function index () {
        return view('pages/mitra/nonaktif-nik');
    }

    public function store (Request $request) {
        $fileSuratPermohonan = $request->file('surat_permohonan');
        $SuratPermohonanPath = $fileSuratPermohonan->store('surat_permohonan', 'public');

        $data = [
            'user_id' => $request->input('user_id'),
            'surat_permohonan' => $SuratPermohonanPath
        ];

        NonAktifNikModel::createNonAktifNik($data);

        return redirect()->to('/mitra/upload/nonaktif-nik')->with('success', 'Upload Pengajuan Penonaktifan NIK');
    }
}
