<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [
        'fname', 'lname','email', 'phone'
    ];

    public function receive()
    {
        return $this->hasOne('App\Models\Receive');
    }
    
}
