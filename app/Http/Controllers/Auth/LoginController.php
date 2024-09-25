<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages/auth/login');
    }

    public function loginAction(Request $request)
    {
        $loginInput = $request->input('username'); // Bisa berupa username atau ID
        $password = $request->input('password');

        // Cek apakah input adalah ID atau username
        if (is_numeric($loginInput)) {
            // Jika input adalah angka, anggap sebagai ID
            $user = User::find($loginInput);
        } else {
            // Jika input adalah string, anggap sebagai username
            $user = User::getUserByUsername($loginInput);
        }

        if ($user && Hash::check($password, $user->password)) {
            // Generate verification code
            $verificationCode = rand(100000, 999999);
            $timestamp = Carbon::now();

            // Save verification code and timestamp to session
            Session::put('verification_code', $verificationCode);
            Session::put('verification_time', $timestamp);
            Session::put('user_id', $user->id);

            // Send verification code to Telegram
            if ($this->sendVerificationCode($user->telegram_id, $verificationCode)) {
                return response()->json(['status' => 'verification_required']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Gagal mengirim kode verifikasi. Silakan coba lagi.'], 500);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Username, ID, atau password yang anda masukkan salah.'], 401);
        }
    }

    public function verifyAction(Request $request)
    {
        $inputCode = $request->input('verification_code');
        $sessionCode = Session::get('verification_code');
        $sessionTime = Session::get('verification_time');
        $userId = Session::get('user_id');

        // Periksa apakah kode verifikasi masih valid(dalam 5 menit)
        $validTime = Carbon::parse($sessionTime)->addMinutes(5);
        $currentTime = Carbon::now();

        if ($currentTime->greaterThan($validTime)) {
            return response()->json(['status' => 'error', 'message' => 'Kode verifikasi telah kadaluarsa.'], 401);
        }

        if ($inputCode == $sessionCode) {
            // Login user
            $user = User::find($userId);
            Auth::login($user);

            // Hapus session verifikasi setelah berhasil login
            Session::forget(['verification_code', 'verification_time', 'user_id']);

            // Redirect based on role
            return response()->json(['status' => 'success', 'redirect_url' => $this->getRedirectUrl($user->role)]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Kode verifikasi yang anda masukkan salah.'], 401);
        }
    }

    public function logoutAction()
    {
        Auth::logout();
        return redirect()->to('/auth/login');
    }

    private function sendVerificationCode($telegramId, $code)
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $message = "Kode verifikasi Login Anda adalah: $code\nHanya dapat digunakan dalam 5 menit.";

        $response = Http::post("https://api.telegram.org/bot$telegramToken/sendMessage", [
            'chat_id' => $telegramId,
            'text' => $message
        ]);

        // Log response for debugging
        Log::info('Telegram Response: ', $response->json());

        return $response->successful();
    }

    private function getRedirectUrl($role)
    {
        switch ($role) {
            case 'HCM':
                return url('/hcm');
            case 'USER':
                return url('/user');
            case 'MITRA':
                return url('/mitra');
            case 'PERFORMANCE':
                return url('/performance');
            case 'FA':
                return url('/fa');
            default:
                return url('/');
        }
    }
}
