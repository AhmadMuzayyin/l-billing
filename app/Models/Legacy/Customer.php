<?php

namespace App\Models\Legacy;

class Customer extends LegacyModel
{
    protected $table = 'tbl_customers';

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'auto_renewal' => 'boolean',
            'created_at' => 'datetime',
            'last_login' => 'datetime',
        ];
    }
}
