<?php

namespace App\Models\Legacy;

class AppLog extends LegacyModel
{
    protected $table = 'tbl_logs';

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}
