<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class ManufacturingOrder extends Model
{
    protected $table ='manufacturing_orders';

    protected $fillable =[
        'order_number',
        'order_date',
        'product_id',
        'production_deadline'
        
    ];

    protected $dates = [
        'created_at',
        'updated_at'   
    ];


    public static function getNextOrderNumber($value)
    {
        // Get the last created order
        $lastOrder = ManufacturingOrder::where('order_number', 'LIKE', $value . '-%')
                    ->orderBy('created_at', 'desc')
                    ->first();


        if (!$lastOrder) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = explode("-",$lastOrder->order_number);
            $number = $number[1];
        }
        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %06d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.

        return sprintf('%06d', intval($number) + 1);
    }

    private function strposX($haystack, $needle, $number)
    {
        if ($number == '1') {
            return strpos($haystack, $needle);
        } elseif ($number > '1') {
            return strpos(
                $haystack,
                $needle,
                $this->strposX($haystack, $needle, $number - 1) + strlen($needle)
            );
        } else {
            return error_log('Error: Value for parameter $number is out of range');
        }
    }


    public function getOrderNumAttribute()
    {
        $position = $this->strposX($this->order_number, "-", 1) + 1;
        return substr($this->order_number, $position);
    }

    public function getOrderPrefixAttribute ()
    {
        $prefix = explode("-", $this->order_number)[0];
        return $prefix;
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
