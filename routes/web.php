<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ErpDashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PartyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

use App\Http\Controllers\SettingController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Main ERP Dashboard Grid
    Route::get('/dashboard', [ErpDashboardController::class, 'index'])->name('dashboard');

    // Sales Module ("9 Sales")
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');

    // Purchases Module ("0 Purchases")
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::delete('/purchases/{id}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

    // Master Modules
    Route::get('/parties', [PartyController::class, 'partiesIndex'])->name('parties.index');
    Route::post('/parties', [PartyController::class, 'partiesStore'])->name('parties.store');

    Route::get('/medical-reps', [PartyController::class, 'medicalRepsIndex'])->name('medical_reps.index');
    Route::post('/medical-reps', [PartyController::class, 'medicalRepsStore'])->name('medical_reps.store');

    Route::get('/companies', [PartyController::class, 'companiesIndex'])->name('companies.index');
    Route::post('/companies', [PartyController::class, 'companiesStore'])->name('companies.store');

    Route::get('/salesmen', [PartyController::class, 'salesmenIndex'])->name('salesmen.index');
    Route::post('/salesmen', [PartyController::class, 'salesmenStore'])->name('salesmen.store');

    Route::get('/banks', [PartyController::class, 'banksIndex'])->name('banks.index');
    Route::post('/banks', [PartyController::class, 'banksStore'])->name('banks.store');

    Route::get('/amanats', [PartyController::class, 'amanatsIndex'])->name('amanats.index');
    Route::post('/amanats', [PartyController::class, 'amanatsStore'])->name('amanats.store');

    Route::get('/lotteries', [PartyController::class, 'lotteriesIndex'])->name('lotteries.index');
    Route::post('/lotteries', [PartyController::class, 'lotteriesStore'])->name('lotteries.store');

    Route::get('/expenses', [PartyController::class, 'expensesIndex'])->name('expenses.index');
    Route::post('/expenses', [PartyController::class, 'expensesStore'])->name('expenses.store');

    Route::get('/vouchers/{type}', [PartyController::class, 'vouchersIndex'])->name('vouchers.index');
    Route::post('/vouchers', [PartyController::class, 'vouchersStore'])->name('vouchers.store');

    Route::get('/reports', [PartyController::class, 'reportsIndex'])->name('reports.index');

    // Security & Settings Routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/verify-admin', [SettingController::class, 'verifyAdminPassword'])->name('settings.verify_admin');
    Route::get('/settings/backup', [SettingController::class, 'downloadBackup'])->name('settings.backup');

    // Automated Direct WhatsApp API Routes
    Route::get('/settings/whatsapp-status', [SettingController::class, 'whatsappStatus'])->name('settings.whatsapp_status');
    Route::post('/settings/whatsapp-logout', [SettingController::class, 'whatsappLogout'])->name('settings.whatsapp_logout');
    Route::post('/settings/send-whatsapp', [SettingController::class, 'sendDirectWhatsapp'])->name('settings.send_whatsapp');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
