<?php


namespace App\Http\Controllers\API\V1;

use App\Models\PaymentType;


class PaymentTypeController extends BaseController
{
    protected $paymentType = '';

  
    public function __construct(PaymentType $paymentType)
    {
        $this->middleware('auth:api');
        $this->paymentType = $paymentType;
    }

 

    public function list()
    {
        $paymentType =  $this->paymentType->pluck('name', 'id');;
        return $this->sendResponse($paymentType, 'Payment Type list');
    }


  
}
