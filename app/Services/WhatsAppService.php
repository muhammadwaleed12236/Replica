<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected static $nodeUrl = 'http://127.0.0.1:3000';

    public static function getStatus()
    {
        try {
            $response = Http::timeout(3)->get(self::$nodeUrl . '/status');
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
            $response = Http::timeout(10)->post(self::$nodeUrl . '/send-message', [
                'phone' => $phone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'success' => false,
                'error' => $response->json('error') ?? 'HTTP Error ' . $response->status(),
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
            $response = Http::timeout(5)->post(self::$nodeUrl . '/logout');
            return $response->json();
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
