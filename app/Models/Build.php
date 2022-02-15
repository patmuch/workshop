<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    
   protected $fillable = ['buildable_id','buildable_type','user_id','notes','production_stage_id'];

  
    public function productionStage()
    {
        return $this->belongsTo('App\Models\ProductionStage');
    }

   
    public function user()
    {
        return $this->belongsTo('App\Models\user');
    }

    public function buildable()
    {
        return $this->morphTo();
    }

    public function materials()
    {
        return $this->belongsToMany('App\Models\Material','build_materials')
                    ->withPivot(['build_id','material_id','quantity'])
                    ->withTimestamps();
    }
  
}
