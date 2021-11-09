<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    protected $fillable = ['name', 'description'];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
