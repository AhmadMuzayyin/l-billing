<?php

namespace App\Models\Legacy;

class Plan extends LegacyModel
{
    protected $table = 'tbl_plans';

    protected function casts(): array
    {
        return [
            'is_radius' => 'boolean',
            'enabled' => 'boolean',
            'plan_expired' => 'integer',
            'expired_date' => 'integer',
        ];
    }
}
