<?php

namespace App\Models\Legacy;

class NetworkRouter extends LegacyModel
{
    protected $table = 'tbl_routers';

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'last_seen' => 'datetime',
        ];
    }
}
