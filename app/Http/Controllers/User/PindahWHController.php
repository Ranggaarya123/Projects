<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PindahWHModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PindahWHController extends Controller
{
    public function index () {
        return view('pages/user/pindah-wh');
    }

    public function store(Request $request) {
        $data = [
            'user_id' => $request->input('user_id'),
            'sto_sebelum' => $request->input('sto_sebelum'),
            'kode_wh_sebelum' => $request->input('kode_wh_sebelum'),
            'sto_tujuan' => $request->input('sto_tujuan'),
            'kode_wh_tujuan' => $request->input('kode_wh_tujuan'),
        ];

       PindahWHModel::createPindahWH($data);

        return redirect()->to('/user/pindah-wh')->with('success', 'Upload Pengajuan Pindah WH');
    }
}
