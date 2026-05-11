<?php

namespace App\Models\Legacy;

class RadAcct extends LegacyModel
{
    protected $table = 'rad_acct';

    protected function casts(): array
    {
        return [
            'acctsessiontime' => 'integer',
            'acctinputoctets' => 'integer',
            'acctoutputoctets' => 'integer',
            'dateAdded' => 'datetime',
        ];
    }
}
