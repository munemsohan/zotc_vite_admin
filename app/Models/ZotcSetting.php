<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZotcSetting extends Model
{
    //fillable protected
    protected $fillable = [
        'type',
        'value',
    ];

    use HasFactory;
}
