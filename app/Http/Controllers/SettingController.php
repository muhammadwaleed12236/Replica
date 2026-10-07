<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SettingController extends Controller
{
    public function index()
    {
        $dateLockDate = Setting::get('date_lock_date');
        $whatsappTemplate = Setting::get('whatsapp_template');
        $autoBackupEnabled = Setting::get('auto_backup_enabled', '1');

        return view('modules.settings', compact('dateLockDate', 'whatsappTemplate', 'autoBackupEnabled'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'date_lock_date' => 'nullable|date',
            'whatsapp_template' => 'required|string',
            'new_admin_password' => 'nullable|string|min:4',
        ]);

        Setting::set('date_lock_date', $request->date_lock_date);
        Setting::set('whatsapp_template', $request->whatsapp_template);
        Setting::set('auto_backup_enabled', $request->has('auto_backup_enabled') ? '1' : '0');

        if ($request->filled('new_admin_password')) {
            Setting::set('admin_password', Hash::make($request->new_admin_password));
        }

        return redirect()->back()->with('success', 'System security settings updated successfully!');
    }

    public function verifyAdminPassword(Request $request)
    {
        $password = $request->input('password');
        $hashed = Setting::get('admin_password');

        if ($hashed && Hash::check($password, $hashed)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid Admin Password!'], 403);
    }

    public function downloadBackup()
    {
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%';");
        
        $backupData = [
            'backup_timestamp' => now()->toIso8601String(),
            'tables' => [],
        ];

        foreach ($tables as $tableObj) {
            $tableName = $tableObj->name;
            $backupData['tables'][$tableName] = DB::table($tableName)->get();
        }

        $fileName = 'backup_' . date('Y_m_d_His') . '.json';
        $jsonContent = json_encode($backupData, JSON_PRETTY_PRINT);

        return Response::make($jsonContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function whatsappStatus()
    {
        $status = \App\Services\WhatsAppService::getStatus();
        return response()->json($status);
    }

    public function whatsappLogout()
    {
        $result = \App\Services\WhatsAppService::logout();
        return response()->json($result);
    }

    public function sendDirectWhatsapp(Request $request)
    {
        $phone = $request->input('phone');
        $message = $request->input('message');

        if (!$phone || !$message) {
            return response()->json(['success' => false, 'error' => 'Phone number and message are required.'], 400);
        }

        $result = \App\Services\WhatsAppService::sendDirectMessage($phone, $message);
        return response()->json($result);
    }
}
