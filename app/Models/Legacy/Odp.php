<?php

namespace App\Models\Legacy;

class Odp extends LegacyModel
{
    protected $table = 'tbl_odps';

    protected function casts(): array
    {
        return [
            'attenuation' => 'decimal:2',
        ];
    }
}
