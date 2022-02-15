<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * 
     * 
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code','description', 'price','stock_availability_id', 'category_id', 'photo'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function builds()
    {
        return $this->hasOne('App\Models\build');
    }

    public function stockAvailability()
    {
        return $this->belongsTo(StockAvailability::class);
    }

    public function salesOrder()
    {
        return $this->hasOne('App\Models\SalesOrder');
    }

    public function manufacturingOrder()
    {
        return $this->hasOne(ManufacturingOrder::class);
    }
}
