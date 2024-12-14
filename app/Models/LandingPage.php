<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class LandingPage extends Model
{
    public function landingPageProducts()
    {
        return $this->hasMany(LandingPageProduct::class);
    }

    public function landingPageAspects()
    {
        return $this->hasOne(ZillaLandingPage::class);
    }
}
