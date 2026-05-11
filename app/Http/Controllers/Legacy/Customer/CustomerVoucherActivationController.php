<?php

namespace App\Http\Controllers\Legacy\Customer;

use App\Http\Requests\ActivateVoucherRequest;
use App\Http\Controllers\Controller;
use App\Models\Legacy\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CustomerVoucherActivationController extends Controller
{
    public function __construct(private VoucherService $voucherService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('legacy/customer/Voucher', [
            'title' => 'Voucher Activation',
            'recentVouchers' => Voucher::query()
                ->latest('created_at')
                ->limit(10)
                ->get(['id', 'code', 'status', 'user', 'used_date']),
        ]);
    }

    public function activate(ActivateVoucherRequest $request): RedirectResponse
    {
        $this->voucherService->activate(
            $request->string('code')->toString(),
            $request->string('customer_username')->toString(),
        );

        return back()->with('success', 'Voucher berhasil diaktifkan.');
    }
}
