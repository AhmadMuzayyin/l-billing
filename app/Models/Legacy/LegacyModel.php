<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class LegacyModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
}
