<?php

namespace App\Services;

use App\Models\Legacy\Transaction;
use App\Models\Legacy\UserRecharge;
use Illuminate\Database\Query\Builder;

class ReportService
{
    public function getDailyReports(?string $date = null): array
    {
        $date = $date ?? now()->toDateString();

        $transactions = Transaction::whereDate('created_at', $date)
            ->groupBy('type')
            ->selectRaw('type, COUNT(*) as count, SUM(amount) as total')
            ->get();

        $recharges = UserRecharge::whereDate('created_at', $date)
            ->count();

        return [
            'date' => $date,
            'transactions' => $transactions,
            'recharges' => $recharges,
            'totalRevenue' => $transactions->sum('total'),
        ];
    }

    public function getActivationHistory(?string $startDate = null, ?string $endDate = null): Builder
    {
        $query = UserRecharge::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->orderByDesc('created_at');
    }

    public function getRevenueReport(?string $startDate = null, ?string $endDate = null): array
    {
        $query = Transaction::query();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return [
            'total' => $query->sum('amount'),
            'count' => $query->count(),
            'average' => $query->avg('amount'),
        ];
    }
}
