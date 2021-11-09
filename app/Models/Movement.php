<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    //

    public function materials()
    {
        return $this->belongsToMany(Material::class)
                    ->using('App\Models\MaterialMovement')
                    ->withPivot(['material_id','movement_id','quantity'])
                    ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    
}
