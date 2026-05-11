<?php

namespace App\Http\Controllers\Legacy\Customer;

use App\Http\Controllers\Controller;
use App\Models\Legacy\Customer;
use App\Services\PaymentHistoryService;
use Inertia\Inertia;
use Inertia\Response;

class CustomerPaymentHistoryController extends Controller
{
    public function __construct(private PaymentHistoryService $service) {}

    public function index(): Response
    {
        $customer = auth()->user();
        $type = request()->query('type');
        $history = $this->service->getPaymentHistory($customer, 15, $type);
        $stats = $this->service->getPaymentStats($customer);

        return Inertia::render('legacy/customer/PaymentHistory', [
            'history' => $history,
            'stats' => $stats,
            'customer' => $customer,
            'filter_type' => $type,
        ]);
    }

    public function monthly(): Response
    {
        $customer = auth()->user();
        $month = request()->query('month');
        $monthlyStats = $this->service->getMonthlyStats($customer, $month);
        $stats = $this->service->getPaymentStats($customer);
        $history = $this->service->getPaymentHistory($customer, 15);

        return Inertia::render('legacy/customer/PaymentMonthly', [
            'monthly_stats' => $monthlyStats,
            'stats' => $stats,
            'history' => $history,
            'customer' => $customer,
            'selected_month' => $month,
        ]);
    }
}
