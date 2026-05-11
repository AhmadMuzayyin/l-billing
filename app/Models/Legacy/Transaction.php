<?php

namespace App\Models\Legacy;

class Transaction extends LegacyModel
{
    protected $table = 'tbl_transactions';

    protected function casts(): array
    {
        return [
            'recharged_on' => 'date',
            'recharged_time' => 'datetime:H:i:s',
            'expiration' => 'date',
            'time' => 'datetime:H:i:s',
        ];
    }
}
