<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        if (isset($data['message']['text'])) {
            $chatId = $data['message']['chat']['id'];
            $text = $data['message']['text'];
            
            // Check if the text is a valid token
            $user = User::where('telegram_token', $text)->first();
            if ($user) {
                // Log in the user
                Auth::login($user);
                
                // Send a success message
                $this->sendMessage($chatId, "You have been logged in successfully!");
            } else {
                // Send a failure message
                $this->sendMessage($chatId, "Invalid token. Please try again.");
            }
        }

        return response('OK', 200);
    }

    private function sendMessage($chatId, $message)
    {
        $url = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}

