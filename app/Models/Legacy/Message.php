<?php

namespace App\Models\Legacy;

class Message extends LegacyModel
{
    protected $table = 'tbl_message';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
