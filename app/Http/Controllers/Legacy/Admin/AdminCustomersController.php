<?php

namespace App\Http\Controllers\Legacy\Admin;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Models\Legacy\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdminCustomersController extends Controller
{
    public function __construct(private CustomerService $customerService)
    {
    }

    public function index(Request $request): Response
    {
        $search = $request->string('search')->toString();

        return Inertia::render('legacy/admin/Customers', [
            'title' => 'Customer',
            'customers' => $this->customerService->list(15, $search),
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $this->customerService->create($request->validated());

        return back()->with('success', 'Customer berhasil dibuat.');
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $this->customerService->update($customer, $request->validated());

        return back()->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $this->customerService->delete($customer);

        return back()->with('success', 'Customer berhasil dihapus.');
    }
}
