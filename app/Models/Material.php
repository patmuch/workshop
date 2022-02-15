<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     */

    protected $fillable = [
        'material_name', 'material_code','description', 'reorder_level','costprice','quantity', 'committed', 'material_category_id', 'uom_id',
    ];


    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function receives()
    {
        return $this->belongsToMany('App\Models\Receive','receive_materials')
                    ->withPivot(['receive_id','material_id','price','quantity'])
                    ->withTimestamps();
    }  
   

    public function movements()
    {
        return $this->belongsToMany(Movement::class)
                    ->using('App\Models\MaterialMovement')
                    ->withPivot(['material_id','movement_id','quantity'])
                    ->withTimestamps();
    } 


    public function builds()
    {
        return $this->belongsToMany('App\Models\Build','build_materials')
                    ->withPivot(['build_id','material_id','quantity'])
                    ->withTimestamps();
    }  
}
