<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    
   protected $fillable = ['product_id','user_id','customer_id','production_time','notes','production_stage_id'];

    public function materials()
    {
        return $this->belongsToMany('App\Models\Material');
    }

    public function productionStage()
    {
        return $this->belongsTo('App\Models\ProductionStage');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
