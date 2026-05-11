<?php

namespace App\Models\Legacy;

class MessageLog extends LegacyModel
{
    protected $table = 'tbl_message_logs';

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }
}
