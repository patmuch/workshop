<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class SalesOrder extends Model
{
    
    protected $fillable = [
        'sorder_number',
        'sorder_date',
        'customer_id',
        'product_id',
        'delivery_deadline',
        'order_status_id'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    ];

   /*protected $dates = [
        
        'sorder_date',
        'delivery_deadline'
    ]; */ 



    public static function getNextOrderNumber($value)
    {
        // Get the last created order
        $lastOrder = SalesOrder::where('sorder_number', 'LIKE', $value . '-%')
                    ->orderBy('created_at', 'desc')
                    ->first();


        if (!$lastOrder) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = explode("-",$lastOrder->sorder_number);
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
        $position = $this->strposX($this->sorder_number, "-", 1) + 1;
        return substr($this->sorder_number, $position);
    }

    public function getOrderPrefixAttribute ()
    {
        $prefix = explode("-", $this->sorder_number)[0];
        return $prefix;
    }


    public function product(){

        return $this->belongsTo('App\Models\Product');
                            
    }


    public function customer(){

        return $this->belongsTo('App\Models\Customer');

    }

    public function orderStatus(){

        return $this->belongsTo('App\Models\OrderStatus');

    }
}