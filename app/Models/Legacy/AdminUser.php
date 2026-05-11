<?php

namespace App\Models\Legacy;

class AdminUser extends LegacyModel
{
    protected $table = 'tbl_users';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected function casts(): array
    {
        return [
            'creationdate' => 'datetime',
            'last_login' => 'datetime',
        ];
    }
}
