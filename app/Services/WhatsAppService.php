<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected static function getNodeUrl()
    {
        return env('WHATSAPP_SERVER_URL', 'http://127.0.0.1:3000');
    }

    public static function getStatus()
    {
        try {
            $response = Http::timeout(3)->get(self::getNodeUrl() . '/status');
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
            'error' => 'WhatsApp Node.js API Service is not running on port 3000.'
        ];
    }

    public static function sendDirectMessage($phone, $message)
    {
        try {
            $response = Http::timeout(10)->post(self::getNodeUrl() . '/send-message', [
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
            $response = Http::timeout(5)->post(self::getNodeUrl() . '/logout');
            return $response->json();
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
