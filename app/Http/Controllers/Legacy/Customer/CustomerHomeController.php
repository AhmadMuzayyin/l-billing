<?php

namespace App\Http\Controllers\Legacy\Customer;

use App\Http\Controllers\Controller;
use App\Models\Legacy\Customer;
use App\Models\Legacy\UserRecharge;
use Inertia\Inertia;
use Inertia\Response;

class CustomerHomeController extends Controller
{
    public function __invoke(): Response
    {
        $user = auth()->user();
        $legacyCustomer = Customer::query()
            ->where('email', $user?->email)
            ->orWhere('username', $user?->name ?? '')
            ->first();

        $activePlans = 0;
        $nextExpiration = null;

        if ($legacyCustomer) {
            $activePlans = UserRecharge::query()
                ->where('customer_id', $legacyCustomer->id)
                ->where('status', 'on')
                ->count();

            $nextExpiration = UserRecharge::query()
                ->where('customer_id', $legacyCustomer->id)
                ->where('status', 'on')
                ->orderBy('expiration')
                ->value('expiration');
        }

        return Inertia::render('legacy/customer/Dashboard', [
            'title' => 'Dashboard',
            'customerName' => $user?->name ?? 'Pelanggan',
            'activePlans' => $activePlans,
            'accountBalance' => $legacyCustomer?->balance ?? 0,
            'nextExpiration' => $nextExpiration,
        ]);
    }
}
