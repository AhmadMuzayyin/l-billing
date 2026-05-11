<?php

namespace App\Services;

use App\Models\Legacy\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentHistoryService
{
    public function getPaymentHistory($customer, int $perPage = 15, ?string $type = null): LengthAwarePaginator
    {
        $query = \App\Models\Legacy\Transaction::where('customer_id', $customer->id);

        if ($type) {
            $query->where('type', $type);
        }

        return $query->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function getPaymentStats($customer): array
    {
        $transactions = \App\Models\Legacy\Transaction::where('customer_id', $customer->id)
            ->get();

        return [
            'total_paid' => (float) $transactions->sum('amount'),
            'total_transactions' => $transactions->count(),
            'topup_count' => (int) $transactions->where('type', 'topup')->count(),
            'purchase_count' => (int) $transactions->where('type', 'purchase')->count(),
        ];
    }

    public function getMonthlyStats($customer, ?string $month = null): array
    {
        $date = $month ? \Carbon\Carbon::createFromFormat('Y-m', $month) : now();

        $transactions = \App\Models\Legacy\Transaction::where('customer_id', $customer->id)
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->get();

        return [
            'month' => $date->format('Y-m'),
            'total' => (float) $transactions->sum('amount'),
            'count' => $transactions->count(),
            'topup' => (float) $transactions->where('type', 'topup')->sum('amount'),
            'purchase' => (float) $transactions->where('type', 'purchase')->sum('amount'),
        ];
    }
}
