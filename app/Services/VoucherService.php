<?php

namespace App\Services;

use App\Models\Legacy\Voucher;

class VoucherService
{
    public function activate(string $code, string $customerUsername): Voucher
    {
        $voucher = Voucher::query()
            ->where('code', $code)
            ->firstOrFail();

        if (strtolower((string) $voucher->status) === 'used') {
            abort(422, 'Voucher sudah digunakan.');
        }

        $voucher->status = 'used';
        $voucher->user = $customerUsername;
        $voucher->used_date = now();
        $voucher->save();

        return $voucher;
    }
}
