<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legacy\Customer;
use App\Models\Legacy\PaymentGatewayTransaction;
use App\Models\Legacy\UserRecharge;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function __invoke(): Response
    {
        $todayRevenue = (float) PaymentGatewayTransaction::query()
            ->whereDate('created_date', now()->toDateString())
            ->sum('price');

        return Inertia::render('legacy/admin/Dashboard', [
            'title' => 'Dashboard',
            'totalCustomers' => Customer::query()->count(),
            'activeServices' => UserRecharge::query()->where('status', 'on')->count(),
            'todayRevenue' => $todayRevenue,
            'pendingOrders' => PaymentGatewayTransaction::query()->where('status', 1)->count(),
        ]);
    }
}
