<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected static $workingUrl = null;

    protected static function getWorkingUrl()
    {
        if (self::$workingUrl) {
            return self::$workingUrl;
        }

        $candidates = array_filter([
            env('WHATSAPP_SERVER_URL'),
            'http://127.0.0.1:3000',
            rtrim(config('app.url', ''), '/'),
        ]);

        foreach (array_unique($candidates) as $url) {
            try {
                $res = Http::timeout(2)->get(rtrim($url, '/') . '/status');
                if ($res->successful()) {
                    self::$workingUrl = rtrim($url, '/');
                    return self::$workingUrl;
                }
            } catch (\Exception $e) {
                // Continue to next candidate
            }
        }

        self::$workingUrl = rtrim(env('WHATSAPP_SERVER_URL', 'http://127.0.0.1:3000'), '/');
        return self::$workingUrl;
    }

    public static function getStatus()
    {
        try {
            $response = Http::timeout(3)->get(self::getWorkingUrl() . '/status');
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp API Service offline: ' . $e->getMessage());
        }

        return [
            'status' => 'offline',
            'qr' => null,
            'phone' => null,
            'error' => 'WhatsApp Node.js API Service is not running.'
        ];
    }

    public static function sendDirectMessage($phone, $message)
    {
        try {
            $response = Http::timeout(10)->post(self::getWorkingUrl() . '/send-message', [
                'phone' => $phone,
                'message' => $message,
            ]);

            $json = $response->json();
            if ($response->successful() && isset($json['success']) && $json['success'] === true) {
                return $json;
            }

            return [
                'success' => false,
                'error' => $json['error'] ?? 'HTTP Error ' . $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message via API: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to connect to WhatsApp API: ' . $e->getMessage(),
            ];
        }
    }

    public static function logout()
    {
        try {
            $response = Http::timeout(5)->post(self::getWorkingUrl() . '/logout');
            return $response->json();
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
