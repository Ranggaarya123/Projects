<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\MutasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MutasiController extends Controller
{
    public function index()
    {
        return view('pages.mitra.mutasi');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|string|',
            'mutasi_type' => 'required|string|in:mutasi-area,mutasi-unit,mutasi-mitra',
            'surat_keterangan_aktif' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'scan_ktp' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'brevet' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        if ($request->mutasi_type === 'mutasi-mitra') {
            $request->validate([
                'surat_pakelaring' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            ]);
        }

        try {
            $data = [
                'user_id' => $request->input('user_id'),
                'mutasi_type' => $request->mutasi_type,
                'surat_keterangan_aktif' => $request->file('surat_keterangan_aktif')->store('surat_keterangan_aktif', 'public'),
                'scan_ktp' => $request->file('scan_ktp')->store('scan_ktp', 'public'),
                'brevet' => $request->file('brevet')->store('brevet', 'public'),
            ];

            if ($request->mutasi_type === 'mutasi-mitra') {
                $data['surat_pakelaring'] = $request->file('surat_pakelaring')->store('surat_pakelaring', 'public');
            }

            // Save the data to the database
            MutasiModel::createMutasi($data);

            Session::flash('success', 'Upload Pengajuan Mutasi');
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/mitra/upload/mutasi');
    }
}
