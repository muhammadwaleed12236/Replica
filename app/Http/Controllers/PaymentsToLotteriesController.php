<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentsToLotteriesController extends Controller
{
    private function ensureTableExists()
    {
        if (!Schema::hasTable('payments_to_lotteries')) {
            Schema::create('payments_to_lotteries', function ($table) {
                $table->id();
                $table->date('payment_date');
                $table->string('lottery');
                $table->text('detail')->nullable();
                $table->decimal('amount', 12, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    public function index(Request $request)
    {
        $this->ensureTableExists();

        $payments = DB::table('payments_to_lotteries')
            ->orderByDesc('id')
            ->get();

        $currentPayment = null;
        if ($request->filled('id')) {
            $currentPayment = DB::table('payments_to_lotteries')
                ->where('id', $request->id)
                ->first();
        }

        return view('payments.lotteries', compact('payments', 'currentPayment'));
    }

    public function store(Request $request)
    {
        $this->ensureTableExists();

        $validated = $request->validate([
            'id' => 'nullable',
            'payment_id' => 'nullable',
            'date' => 'nullable|date',
            'payment_date' => 'nullable|date',
            'lottery' => 'nullable|string|max:255',
            'scheme_name' => 'nullable|string|max:255',
            'detail' => 'nullable|string|max:5000',
            'remarks' => 'nullable|string|max:5000',
            'amount' => 'required|numeric|min:0',
        ]);

        $id = $request->input('id') ?: $request->input('payment_id');
        $date = $request->input('payment_date') ?: ($request->input('date') ?: date('Y-m-d'));
        $lottery = $request->input('lottery') ?: ($request->input('scheme_name') ?: 'General Lottery');
        $detail = $request->input('detail') ?: $request->input('remarks');
        $amount = $request->input('amount');

        if ($id && DB::table('payments_to_lotteries')->where('id', $id)->exists()) {
            DB::table('payments_to_lotteries')
                ->where('id', $id)
                ->update([
                    'payment_date' => $date,
                    'lottery' => $lottery,
                    'detail' => $detail,
                    'amount' => $amount,
                    'updated_at' => now(),
                ]);
            $msg = 'Lottery payment updated successfully.';
        } else {
            $newId = DB::table('payments_to_lotteries')->insertGetId([
                'payment_date' => $date,
                'lottery' => $lottery,
                'detail' => $detail,
                'amount' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $id = $newId;
            $msg = 'Lottery payment saved successfully.';
        }

        return redirect()
            ->route('payments-to-lotteries.index', ['id' => $id])
            ->with('success', $msg);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'lottery' => 'required|string|max:255',
            'detail' => 'nullable|string|max:5000',
            'amount' => 'required|numeric|min:0',
        ]);

        $exists = DB::table('payments_to_lotteries')
            ->where('id', $id)
            ->exists();

        if (!$exists) {
            return redirect()
                ->route('payments-to-lotteries.index')
                ->with('error', 'Payment not found.');
        }

        DB::table('payments_to_lotteries')
            ->where('id', $id)
            ->update([
                'payment_date' => $validated['payment_date'],
                'lottery' => $validated['lottery'],
                'detail' => $validated['detail'] ?? null,
                'amount' => $validated['amount'],
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('payments-to-lotteries.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(string $id)
    {
        $deleted = DB::table('payments_to_lotteries')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('payments-to-lotteries.index')
            ->with(
                $deleted ? 'success' : 'error',
                $deleted
                    ? 'Payment deleted successfully.'
                    : 'Payment not found.'
            );
    }
}