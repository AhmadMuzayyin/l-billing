<?php

namespace App\Models\Legacy;

class CustomerInbox extends LegacyModel
{
    protected $table = 'tbl_customers_inbox';

    protected function casts(): array
    {
        return [
            'date_created' => 'datetime',
            'date_read' => 'datetime',
        ];
    }
}
