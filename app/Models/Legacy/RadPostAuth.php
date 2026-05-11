<?php

namespace App\Models\Legacy;

class RadPostAuth extends LegacyModel
{
    protected $table = 'radpostauth';

    protected function casts(): array
    {
        return [
            'authdate' => 'datetime',
        ];
    }
}
