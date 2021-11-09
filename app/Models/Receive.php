<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
     protected $fillable = ['receive_date, supplier_id','user_id','payment_id','grandtotal','tax','discount','amount','due'];

    public function materials()
    {
        return $this->belongsToMany('App\Models\Material','receive_materials')
                    ->withPivot(['receive_id','material_id','costprice','quantity','subtotal'])
                    ->withTimestamps();
    }


    public function paymentType()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');

    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
