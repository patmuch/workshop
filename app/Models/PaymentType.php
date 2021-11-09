<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table ='payment_type';
        

    public function receive(){

        return $this->hasOne('App\Models\Receive');
    }
}
