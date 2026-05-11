<?php

namespace App\Http\Controllers\Legacy\Customer;

use App\Http\Controllers\Controller;
use App\Models\Legacy\Plan;
use App\Services\PackageService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CustomerPackageController extends Controller
{
    public function __construct(private PackageService $service) {}

    public function index(): Response
    {
        $customer = auth()->user();
        $packages = $this->service->getAvailablePackages();

        return Inertia::render('legacy/customer/Packages', [
            'packages' => $packages,
            'customer' => $customer,
        ]);
    }

    public function purchase($plan): Response
    {
        $customer = auth()->user();
        $plan = Plan::findOrFail($plan);
        return Inertia::render('legacy/customer/PackagePurchase', [
            'package' => $plan,
            'customer' => $customer,
            'balance' => $customer->balance,
        ]);
    }

    public function store($plan): RedirectResponse
    {
        $customer = auth()->user();
        $plan = Plan::findOrFail($plan);
        $result = $this->service->purchasePackage($customer, $plan);

        if (!$result) {
            return back()->with('error', 'Saldo tidak cukup untuk membeli paket ini');
        }

        return redirect()->route('legacy.customer.buy-package')
            ->with('success', 'Paket berhasil dibeli');
    }

    public function history(): Response
    {
        $customer = auth()->user();
        $history = $this->service->getCustomerPurchaseHistory($customer);

        return Inertia::render('legacy/customer/PackageHistory', [
            'history' => $history,
            'customer' => $customer,
        ]);
    }
}
