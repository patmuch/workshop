<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAvailability extends Model
{
    protected $table ='stock_availability';
        

    public function products(){

        return $this->hasMany('App\Models\Product');
    }
}
