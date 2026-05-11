<?php

namespace App\Http\Controllers\Legacy\Customer;

use App\Http\Controllers\Controller;
use App\Services\BalanceService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class CustomerBalanceController extends Controller
{
    public function __construct(private BalanceService $service) {}

    public function index(): Response
    {
        $customer = auth()->user();
        $balance = $this->service->getBalance($customer);
        $transactions = \App\Models\Legacy\Transaction::where('customer_id', $customer->id)
            ->whereIn('type', ['topup', 'deduction'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('legacy/customer/Balance', [
            'customer' => $customer,
            'balance' => $balance,
            'transactions' => $transactions,
        ]);
    }

    public function create(): Response
    {
        $customer = auth()->user();
        return Inertia::render('legacy/customer/BalanceForm', [
            'customer' => $customer,
            'balance' => $this->service->getBalance($customer),
        ]);
    }

    public function store(): RedirectResponse
    {
        $customer = auth()->user();
        $amount = request()->validate(['amount' => 'required|numeric|min:1'])['amount'];

        $this->service->topupBalance($customer, $amount, 'manual');

        return redirect()->route('legacy.customer.buy-balance')
            ->with('success', 'Saldo berhasil ditambahkan');
    }
}
