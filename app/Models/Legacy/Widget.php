<?php

namespace App\Models\Legacy;

class Widget extends LegacyModel
{
    protected $table = 'tbl_widgets';

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
        ];
    }
}
