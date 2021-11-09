<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'fname', 'lname','email', 'phone'
    ];
    
    public function builds()
    {
        return $this->hasMany('App\Models\build');
    }

    public function salesOrder()
    {
        return $this->hasOne('App\Models\SalesOrder');
    }
}
