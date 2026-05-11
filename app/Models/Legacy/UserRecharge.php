<?php

namespace App\Models\Legacy;

class UserRecharge extends LegacyModel
{
    protected $table = 'tbl_user_recharges';

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
