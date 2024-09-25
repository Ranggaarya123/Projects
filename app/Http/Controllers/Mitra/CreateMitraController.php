<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\CreateMitraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\MitraCreated;
use Illuminate\Support\Facades\Mail;

class CreateMitraController extends Controller
{
    public function index () {
        return view('pages/mitra/create-mitra');
    }

    public function store (Request $request) {
        $fileKhsMitra = $request->file('khs_mitra');
        $fileSuratKeteranganAktif = $request->file('surat_keterangan_aktif');
        $fileScanBpjs = $request->file('scan_bpjs');
        $fileScanKtp = $request->file('scan_ktp');
        $fileFotoMitra = $request->file('foto_mitra');
        $fileExcelCreateNikMitra = $request->file('excelcreate_nikmitra');
        
        $KhsMitraPath = $fileKhsMitra->store('khs_mitra', 'public');
        $SuratKeteranganAktifPath = $fileSuratKeteranganAktif->store('surat_keterangan_aktif', 'public');
        $scanBpjsPath = $fileScanBpjs->store('scan_bpjs', 'public');
        $scanKtpPath = $fileScanKtp->store('scan_ktp', 'public');
        $FotoMitraPath = $fileFotoMitra->store('foto_mitra', 'public');
        $ExcelCreateNikMitraPath = $fileExcelCreateNikMitra->store('excelcreate_nikmitra', 'public');

        $data = [
            'user_id' => Auth::user()->id,
            'username' => $request->input('username'),
            'khs_mitra' => $KhsMitraPath,
            'surat_keterangan_aktif' => $SuratKeteranganAktifPath,
            'scan_bpjs' => $scanBpjsPath,
            'scan_ktp' => $scanKtpPath,
            'foto_mitra' => $FotoMitraPath,
            'excelcreate_nikmitra' => $ExcelCreateNikMitraPath
        ];

        CreateMitraModel::createCreateMitra($data);

        // Kirim email dengan lampiran
        $files = [$fileKhsMitra, $fileSuratKeteranganAktif, $fileScanBpjs, $fileScanKtp, $fileFotoMitra, $fileExcelCreateNikMitra];
        Mail::to('dinainggrid@gmail.com')->send(new MitraCreated($data, $files));


        return redirect()->to('/mitra/upload/create-mitra')->with('success', 'Mengajukan Create NIK Mitra Baru');
    }
}
