<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\AktivasiNikModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivasiNIKController extends Controller
{
    public function index () {
        return view('pages/mitra/aktivasi-nik');
    }

    public function store (Request $request) {
        $fileSuratKeterangan = $request->file('surat_keterangan_aktif');
        $fileScanBpjs = $request->file('scan_bpjs');
        $fileScanKtp = $request->file('scan_ktp');
        $fileSertifikatBrevet = $request->file('sertifikat_brevet');
        
        $suratKeteranganPath = $fileSuratKeterangan->store('surat_keterangan_aktif', 'public');
        $scanBpjsPath = $fileScanBpjs->store('scan_bpjs', 'public');
        $scanKtpPath = $fileScanKtp->store('scan_ktp', 'public');
        $sertifikatBrevetPath = $fileSertifikatBrevet->store('sertifikat_brevet', 'public');

        $data = [
            'user_id' => $request->input('user_id'),
            'surat_keterangan_aktif' => $suratKeteranganPath,
            'scan_bpjs' => $scanBpjsPath,
            'scan_ktp' => $scanKtpPath,
            'sertifikat_brevet' => $sertifikatBrevetPath
        ];

        AktivasiNikModel::createAktivasiNik($data);

        return redirect()->to('/mitra/upload/aktivasi-nik')->with('success', 'Upload Aktivasi NIK');
    }

}
