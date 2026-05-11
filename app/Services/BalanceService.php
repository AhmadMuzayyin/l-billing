<?php

namespace App\Services;

use App\Models\Legacy\Customer;
use App\Models\Legacy\Transaction;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    public function topupBalance($customer, float $amount, string $method = 'manual'): Transaction
    {
        DB::beginTransaction();

        try {
            $customer->increment('balance', $amount);

            $transaction = Transaction::create([
                'customer_id' => $customer->id,
                'type' => 'topup',
                'method' => $method,
                'amount' => $amount,
                'status' => 'paid',
                'description' => "Top-up balance: Rp {$amount}",
                'created_at' => now(),
            ]);

            DB::commit();

            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getBalance($customer): float
    {
        return (float) $customer->balance;
    }

    public function deductBalance($customer, float $amount, string $description = ''): bool
    {
        if ($customer->balance < $amount) {
            return false;
        }

        DB::beginTransaction();

        try {
            $customer->decrement('balance', $amount);

            Transaction::create([
                'customer_id' => $customer->id,
                'type' => 'deduction',
                'amount' => $amount,
                'status' => 'paid',
                'description' => $description,
                'created_at' => now(),
            ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
