<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    use HasFactory;

    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
