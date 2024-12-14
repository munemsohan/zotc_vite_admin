<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class ZillaLandingPage extends Model
{
    public function landingPageProducts()
    {
        return $this->hasMany(LandingPageProduct::class);
    }
}
