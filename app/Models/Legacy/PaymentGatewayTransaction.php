<?php

namespace App\Models\Legacy;

class PaymentGatewayTransaction extends LegacyModel
{
    protected $table = 'tbl_payment_gateway';

    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'expired_date' => 'datetime',
            'created_date' => 'datetime',
            'paid_date' => 'datetime',
        ];
    }
}
