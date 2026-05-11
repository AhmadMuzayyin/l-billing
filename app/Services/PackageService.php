<?php

namespace App\Services;

use App\Models\Legacy\Customer;
use App\Models\Legacy\Plan;
use Illuminate\Support\Facades\DB;

class PackageService
{
    public function getAvailablePackages(int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Plan::where('enabled', 1)
            ->paginate($perPage);
    }

    public function purchasePackage($customer, Plan $plan): bool
    {
        if ($customer->balance < $plan->price) {
            return false;
        }

        DB::beginTransaction();

        try {
            $customer->decrement('balance', $plan->price);

            $currentDate = now();
            $expiryDate = $currentDate->addDays($plan->validity_days);

            $customer->update([
                'last_login' => $currentDate,
                'expiration_date' => $expiryDate,
                'service_type' => $plan->type,
            ]);

            \App\Models\Legacy\Transaction::create([
                'customer_id' => $customer->id,
                'plan_id' => $plan->id,
                'type' => 'purchase',
                'amount' => $plan->price,
                'status' => 'paid',
                'description' => "Pembelian paket: {$plan->name}",
                'created_at' => $currentDate,
            ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getCustomerPurchaseHistory($customer, int $perPage = 15): \Illuminate\Pagination\LengthAwarePaginator
    {
        return \App\Models\Legacy\Transaction::where('customer_id', $customer->id)
            ->where('type', 'purchase')
            ->with('plan')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}
