<?php

namespace App\Models\Legacy;

class RadiusAccounting extends LegacyModel
{
    protected $table = 'radacct';

    protected $primaryKey = 'radacctid';

    protected function casts(): array
    {
        return [
            'acctstarttime' => 'datetime',
            'acctupdatetime' => 'datetime',
            'acctstoptime' => 'datetime',
        ];
    }
}
