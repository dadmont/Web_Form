<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YandexCaptchaService
{
    public function verify(?string $token): bool
    {
        // if (app()->environment('local')) {
            // return true; // Пропускаем проверку в локальном окружении
        // }   
        if (empty($token)) {
            Log::error('SmartCaptcha: Empty token received');
            return false;
        }

        try {
            $response = Http::asForm()->post('https://smartcaptcha.yandexcloud.net/validate', [
                'secret' => env('YANDEX_SMARTCAPTCHA_SERVER_KEY'),
                'token' => $token,
                'ip' => request()->ip(),
            ]);

            if (!$response->successful()) {
                Log::error('SmartCaptcha API error', ['response' => $response->body()]);
                return false;
            }

            return $response->json('status') === 'ok';
        } catch (\Exception $e) {
            Log::error('SmartCaptcha verification failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}