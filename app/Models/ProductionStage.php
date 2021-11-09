<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStage extends Model
{
    
        

    public function build(){

        return $this->hasMany('App\Models\Build');
    }
}
