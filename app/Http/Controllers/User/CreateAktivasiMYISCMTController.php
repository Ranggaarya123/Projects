<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreateAktivasiMYISCMTModel;
use App\Models\MitraManajemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CreateAktivasiMYISCMTController extends Controller
{
    public function index()
    {
        return view('pages/user/ca-myiscmt');
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'myiscmt_type_combined' => 'required|string',
            'username' => 'required|string',
            'user_id' => 'required|string',
            'email' => 'required|string',
            'id_tele' => 'required|string',
            'no_hp' => 'required|string',
            'sto' => 'required|string',
            'kode_wh' => 'required|string',
            'capture_hcmbot' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'capture_tactical' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);
    
        try {
            // Ambil status_myi dan status_scmt dari tabel mitra_manajemen berdasarkan user_id dari form
            $user_id = $request->input('user_id');
            $mitraManajemen = MitraManajemen::where('user_id', $user_id)->first();
    
            if (!$mitraManajemen) {
                throw new \Exception('Data Mitra Manajemen tidak ditemukan untuk user_id: ' . $user_id);
            }
    
            $errors = [];
            $myiDisabled = false;
            $scmtDisabled = false;

            // Cek status_tactical
            if (in_array('create-myi', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_tactical, [0, 2])) {
                $myiDisabled = true;
                $errors[] = "Tactical NOK, Validasi tactical dahulu!";
            }
            if (in_array('aktivasi-myi', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_tactical, [0, 2])) {
                $myiDisabled = true;
                $errors[] = "Tactical NOK, Validasi tactical dahulu!";
            }
            if (in_array('create-scmt', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_tactical, [0, 2])) {
                $scmtDisabled = true;
                $errors[] = "Tactical NOK, Validasi tactical dahulu!";
            }
            if (in_array('aktivasi-scmt', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_tactical, [0, 2])) {
                $scmtDisabled = true;
                $errors[] = "Tactical NOK, Validasi tactical dahulu!";
            }

            // Cek status_myi
            if (in_array('create-myi', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_myi, [1, 2])) {
                $myiDisabled = true;
                $errors[] = "Sudah pernah melakukan 'Create MYI', Cukup melakukan 'Aktivasi' saja!";
            }
            if (in_array('aktivasi-myi', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_myi, [0])) {
                $myiDisabled = true;
                $errors[] = "Belum melakukan 'Create MYI', Silahkan Create MYI dulu!";
            }
    
            // Cek status_scmt
            if (in_array('create-scmt', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_scmt, [1, 2])) {
                $scmtDisabled = true;
                $errors[] = "Sudah pernah melakukan 'Create SCMT', Cukup melakukan 'Aktivasi' saja!";
            }
            if (in_array('aktivasi-scmt', $request->input('myiscmt_types', [])) && in_array($mitraManajemen->status_scmt, [0])) {
                $scmtDisabled = true;
                $errors[] = "Belum melakukan 'Create SCMT', Silahkan Create SCMT dulu!";
            }
    
            // Jika ada error, kembalikan ke form dengan pesan error
            if ($myiDisabled || $scmtDisabled) {
                return redirect()->back()->withErrors($errors)->withInput();
            }
    
            // Jika tidak ada error, simpan data
            $data = [
                'myiscmt_type' => $request->myiscmt_type_combined,
                'username' => $request->username,
                'user_id' => $request->user_id,
                'email' => $request->email,
                'id_tele' => $request->id_tele,
                'no_hp' => $request->no_hp,
                'sto' => $request->sto,
                'kode_wh' => $request->kode_wh,
                'capture_hcmbot' => $request->file('capture_hcmbot')->store('capture_hcmbot', 'public'),
                'capture_tactical' => $request->file('capture_tactical')->store('capture_tactical', 'public'),
            ];
    
            // Simpan data ke database
            CreateAktivasiMYISCMTModel::createCreateAktivasiMYISCMT($data);
    
            Session::flash('success', 'Upload Pengajuan Create/Aktivasi MYI-SCMT');
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    
        return redirect()->to('/user/ca-myiscmt');
    }
    

}
