<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function create()
    {
        return view('pages.auth.create-user');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|string|unique:users,id',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'telegram_id' => 'nullable|string',
            'role' => 'required|string',
        ]);

        // Simpan data pengguna ke session
        Session::put('user_data', $request->all());

        // Generate kode verifikasi
        $verificationCode = rand(100000, 999999);

        // Simpan kode verifikasi ke session
        Session::put('verification_code', $verificationCode);

        // Kirim kode verifikasi ke email
        Mail::to('Dinainggrid@gmail.com')->send(new VerificationCodeMail($verificationCode));

        // Kirim respon JSON
        return response()->json([
            'status' => 'verification_sent',
            'message' => 'Kode verifikasi telah dikirim ke email Anda.'
        ]);
    }

    public function verify(Request $request)
    {
        // Validasi kode verifikasi
        $request->validate([
            'verification_code' => 'required|string',
        ]);

        // Ambil kode verifikasi dari session
        $storedCode = Session::get('verification_code');

        if ($request->input('verification_code') == $storedCode) {
            // Ambil data pengguna dari session
            $userData = Session::get('user_data');

            // Simpan pengguna baru ke database
            $user = new User([
                'id' => $userData['id'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'telegram_id' => $userData['telegram_id'],
                'role' => $userData['role'],
            ]);

            $user->save();

            // Hapus data dari session
            Session::forget(['user_data', 'verification_code']);

            // Kirim respon sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Pengguna berhasil ditambahkan.'
            ]);
        } else {
            // Kirim respon error
            return response()->json([
                'status' => 'error',
                'message' => 'Kode verifikasi salah atau telah kadaluarsa.'
            ], 422);
        }
    }
}
