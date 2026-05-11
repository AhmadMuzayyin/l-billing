<?php

namespace App\Models\Legacy;

class Voucher extends LegacyModel
{
    protected $table = 'tbl_voucher';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'used_date' => 'datetime',
        ];
    }
}
