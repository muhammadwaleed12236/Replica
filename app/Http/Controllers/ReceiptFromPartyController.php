<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReceiptFromPartyController extends Controller
{
    private function ensureTableExists()
    {
        if (!Schema::hasTable('receipts_from_parties')) {
            Schema::create('receipts_from_parties', function ($table) {
                $table->id();
                $table->date('date');
                $table->string('party');
                $table->text('detail')->nullable();
                $table->decimal('amount', 12, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    public function index(Request $request)
    {
        $this->ensureTableExists();

        $receipts = DB::table('receipts_from_parties')
            ->orderByDesc('id')
            ->get();

        $currentReceipt = null;
        if ($request->filled('id')) {
            $currentReceipt = DB::table('receipts_from_parties')
                ->where('id', $request->id)
                ->first();
        }

        return view('receipts.from-parties', compact('receipts', 'currentReceipt'));
    }

    public function store(Request $request)
    {
        $this->ensureTableExists();

        $validated = $request->validate([
            'date' => 'required|date',
            'party' => 'required|string|max:255',
            'detail' => 'nullable|string|max:5000',
            'amount' => 'required|numeric|min:0',
        ]);

        $id = $request->input('id') ?: $request->input('receipt_id');

        if ($id && DB::table('receipts_from_parties')->where('id', $id)->exists()) {
            DB::table('receipts_from_parties')
                ->where('id', $id)
                ->update([
                    'date' => $validated['date'],
                    'party' => $validated['party'],
                    'detail' => $validated['detail'] ?? null,
                    'amount' => $validated['amount'],
                    'updated_at' => now(),
                ]);
            $msg = 'Receipt updated successfully.';
        } else {
            $id = DB::table('receipts_from_parties')->insertGetId([
                'date' => $validated['date'],
                'party' => $validated['party'],
                'detail' => $validated['detail'] ?? null,
                'amount' => $validated['amount'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $msg = 'Receipt created successfully.';
        }

        return redirect()
            ->route('receipts-from-parties.index', ['id' => $id])
            ->with('success', $msg);
    }

    public function destroy($id)
    {
        $this->ensureTableExists();

        DB::table('receipts_from_parties')->where('id', $id)->delete();

        return redirect()
            ->route('receipts-from-parties.index')
            ->with('success', 'Receipt deleted successfully.');
    }
}

