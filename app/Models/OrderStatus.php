<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table ='order_status';
        

    public function salesOrder(){

        return $this->hasOne('App\Models\SalesOrder');
    }
}
