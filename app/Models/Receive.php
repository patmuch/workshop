<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    protected $fillable = ['receive_date', 'purchase_order', 'supplier_id','user_id'];

    public function materials()
    {
        return $this->belongsToMany('App\Models\Material','receive_materials')
                    ->withPivot(['receive_id','material_id','price','quantity'])
                    ->withTimestamps();
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
