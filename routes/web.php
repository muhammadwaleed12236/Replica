
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ErpDashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReceiptFromPartyController;
use App\Http\Controllers\PaymentsToLotteriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // =========================================================
    // MAIN ERP DASHBOARD
    // =========================================================

    Route::get('/dashboard', [ErpDashboardController::class, 'index'])
        ->name('dashboard');


    // =========================================================
    // SALES MODULE
    // =========================================================

    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    Route::delete('/sales/{id}', [SaleController::class, 'destroy'])
        ->name('sales.destroy');


    // =========================================================
    // PURCHASES MODULE
    // =========================================================

    Route::get('/purchases', [PurchaseController::class, 'index'])
        ->name('purchases.index');

    Route::post('/purchases', [PurchaseController::class, 'store'])
        ->name('purchases.store');

    Route::delete('/purchases/{id}', [PurchaseController::class, 'destroy'])
        ->name('purchases.destroy');


    // =========================================================
    // MASTER MODULES
    // =========================================================

    // 1 - Parties
    Route::view('/parties', 'receipts.from-parties')
        ->name('parties.index');

    Route::post('/parties', [PartyController::class, 'partiesStore'])
        ->name('parties.store');

    Route::delete('/parties/{id}', [PartyController::class, 'partiesDestroy'])
        ->name('parties.destroy');


    // 2 - Medical Representatives & Last Closing
    Route::get('/medical-reps', [PartyController::class, 'medicalRepsIndex'])
        ->name('medical_reps.index');

    Route::get('/last-closing', [PartyController::class, 'lastClosingIndex'])
        ->name('last_closing.index');

    Route::post('/medical-reps', [PartyController::class, 'medicalRepsStore'])
        ->name('medical_reps.store');

    Route::delete('/medical-reps/{id}', [PartyController::class, 'medicalRepsDestroy'])
        ->name('medical_reps.destroy');


    // 3 - Companies
    Route::get('/companies', [PartyController::class, 'companiesIndex'])
        ->name('companies.index');

    Route::post('/companies', [PartyController::class, 'companiesStore'])
        ->name('companies.store');

    Route::delete('/companies/{id}', [PartyController::class, 'companiesDestroy'])
        ->name('companies.destroy');


    // 4 - Salesmen
    Route::get('/salesmen', [PartyController::class, 'salesmenIndex'])
        ->name('salesmen.index');

    Route::post('/salesmen', [PartyController::class, 'salesmenStore'])
        ->name('salesmen.store');

    Route::delete('/salesmen/{id}', [PartyController::class, 'salesmenDestroy'])
        ->name('salesmen.destroy');


    // 5 - Banks
    Route::get('/banks', [PartyController::class, 'banksIndex'])
        ->name('banks.index');

    Route::post('/banks', [PartyController::class, 'banksStore'])
        ->name('banks.store');

    Route::delete('/banks/{id}', [PartyController::class, 'banksDestroy'])
        ->name('banks.destroy');


    // 6 - Expenses
    Route::get('/expenses', [PartyController::class, 'expensesIndex'])
        ->name('expenses.index');

    Route::post('/expenses', [PartyController::class, 'expensesStore'])
        ->name('expenses.store');

    Route::delete('/expenses/{id}', [PartyController::class, 'expensesDestroy'])
        ->name('expenses.destroy');


    // 7 - Amanats
    Route::get('/amanats', [PartyController::class, 'amanatsIndex'])
        ->name('amanats.index');

    Route::post('/amanats', [PartyController::class, 'amanatsStore'])
        ->name('amanats.store');

    Route::delete('/amanats/{id}', [PartyController::class, 'amanatsDestroy'])
        ->name('amanats.destroy');


    // 8 - Lotteries (master)
    Route::get('/lotteries', [PartyController::class, 'lotteriesIndex'])
        ->name('lotteries.index');

    Route::post('/lotteries', [PartyController::class, 'lotteriesStore'])
        ->name('lotteries.store');

    Route::delete('/lotteries/{id}', [PartyController::class, 'lotteriesDestroy'])
        ->name('lotteries.destroy');


    // =========================================================
    // RECEIPTS MODULE
    // =========================================================

    // Receipts main page
    Route::view('/receipts', 'receipts.index')
        ->name('receipts.index');

    // Receipts From Parties page
    Route::get('/receipts-from-parties', [
        ReceiptFromPartyController::class,
        'index'
    ])->name('receipts-from-parties.index');

    // Save Receipt From Party
    Route::post('/receipts-from-parties', [
        ReceiptFromPartyController::class,
        'store'
    ])->name('receipts-from-parties.store');

    // Delete Receipt From Party
    Route::delete('/receipts-from-parties/{id}', [
        ReceiptFromPartyController::class,
        'destroy'
    ])->name('receipts-from-parties.destroy');


    // =========================================================
    // PAYMENTS MODULE
    // =========================================================

    // Payments main page
    Route::view('/payments', 'payments.index')
        ->name('payments.index');

    // Payments to Lotteries - list page
    Route::get('/payments-to-lotteries', [
        PaymentsToLotteriesController::class,
        'index'
    ])->name('payments-to-lotteries.index');

    // Create new payment
    Route::post('/payments-to-lotteries', [
        PaymentsToLotteriesController::class,
        'store'
    ])->name('payments-to-lotteries.store');

    // Update selected payment
    Route::put('/payments-to-lotteries/{id}', [
        PaymentsToLotteriesController::class,
        'update'
    ])->name('payments-to-lotteries.update');

    // Delete selected payment
    Route::delete('/payments-to-lotteries/{id}', [
        PaymentsToLotteriesController::class,
        'destroy'
    ])->name('payments-to-lotteries.destroy');


    // =========================================================
    // VOUCHERS
    // =========================================================

    Route::get('/vouchers/{type}', [PartyController::class, 'vouchersIndex'])
        ->name('vouchers.index');

    Route::post('/vouchers', [PartyController::class, 'vouchersStore'])
        ->name('vouchers.store');

    Route::delete('/vouchers/{id}', [PartyController::class, 'vouchersDestroy'])
        ->name('vouchers.destroy');


    // =========================================================
    // REPORTS
    // =========================================================

    Route::get('/reports', [PartyController::class, 'reportsIndex'])
        ->name('reports.index');


    // =========================================================
    // SETTINGS
    // =========================================================

    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::post('/settings', [SettingController::class, 'update'])
        ->name('settings.update');

    Route::post('/settings/verify-admin', [
        SettingController::class,
        'verifyAdminPassword'
    ])->name('settings.verify_admin');

    Route::get('/settings/backup', [
        SettingController::class,
        'downloadBackup'
    ])->name('settings.backup');


    // =========================================================
    // WHATSAPP
    // =========================================================

    Route::get('/settings/whatsapp-status', [
        SettingController::class,
        'whatsappStatus'
    ])->name('settings.whatsapp_status');

    Route::post('/settings/whatsapp-logout', [
        SettingController::class,
        'whatsappLogout'
    ])->name('settings.whatsapp_logout');

    Route::post('/settings/send-whatsapp', [
        SettingController::class,
        'sendDirectWhatsapp'
    ])->name('settings.send_whatsapp');


    // =========================================================
    // PROFILE
    // =========================================================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// =============================================================
// AUTHENTICATION ROUTES
// =============================================================

require __DIR__ . '/auth.php';