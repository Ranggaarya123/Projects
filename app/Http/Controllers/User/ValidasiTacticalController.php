<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ValidasiTacticalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidasiTacticalController extends Controller
{
    public function index () {
        return view('pages/user/validasi-tactical');
    }

    public function store (Request $request) {
        if ($request->hasFile('capture_tactical')) {
            $data = [
                'nama' => $request->input('nama'),
                'user_id' => $request->input('user_id'),
            ];

            $file = $request->file('capture_tactical');
            $filePath = $file->store('capture_tactical', 'public');
            $data['capture_tactical'] = $filePath;

            ValidasiTacticalModel::createValidasiTactical($data);

            return redirect()->to('/user/validasi-tactical')->with('success', 'Upload validasi Tactical.');
        } else {
            return redirect()->back()->with('error', 'File capture tactical harus diunggah.');
        }
    }
}
