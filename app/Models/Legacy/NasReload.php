<?php

namespace App\Models\Legacy;

class NasReload extends LegacyModel
{
    protected $table = 'nasreload';

    protected $primaryKey = 'nasipaddress';

    protected $keyType = 'string';

    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'reloadtime' => 'datetime',
        ];
    }
}
