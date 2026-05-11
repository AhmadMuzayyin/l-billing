<?php

namespace App\Models\Legacy;

class Coupon extends LegacyModel
{
    protected $table = 'tbl_coupons';

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
