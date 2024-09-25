<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DuplicateWHModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DuplicateWHController extends Controller
{
    public function index () {
        return view('pages/user/duplicate-wh');
    }

    public function store(Request $request) {
        $data = [
            'user_id' => $request->input('user_id'),
            'sto' => $request->input('sto'),
            'kode_wh' => $request->input('kode_wh'),
        ];

        DuplicateWHModel::createDuplicateWH($data);

        return redirect()->to('/user/duplicate-wh')->with('success', 'Upload Pengajuan Duplicate WH');
    }
}
