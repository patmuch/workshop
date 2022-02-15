<?php


namespace App\Http\Controllers\API\V1;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Build;
use App\Models\ManufacturingOrder;
use App\Models\SalesOrder;


class DashboardController extends BaseController
{
   
    public function __construct()
    {
        $this->middleware('auth:api');
      
    }

  
    public function customer()
    {
        $customer = Customer::count();
        return $this->sendResponse($customer, 'total customers');
    }



    public function salesOrder()
    {
        $salesOrder = SalesOrder::latest()->with('customer','product','orderStatus')->take(5)->get();
        
        return $this->sendResponse($salesOrder, 'SalesOrder list');
    }


    public function manufacturingOrder()
    {
        $manufacturingOrder = ManufacturingOrder::latest()->with('product')->take(5)->get();
        return $this->sendResponse($manufacturingOrder, 'Manufacturing Order');
    }




    public function customerOrder()
    {
        $customerOrder = salesOrder::count();

        return $this->sendResponse($customerOrder, 'Total Customers Order');
    }

   

    public function stock()
    {
         $stock = DB::table('materials')->select(DB::raw('SUM(quantity*costprice)AS total'))
         ->first();

        return $this->sendResponse( $stock, 'Stock value');
    }

    public function productionCount(){

        $prodCount = Build::count();

        return  $this->sendResponse( $prodCount, 'total builds');

    }

    public function workInProgess(){

        $wip = Build::where('production_stage_id', 1)->count();

        return  $this->sendResponse( $wip, 'total work-in-progess');

    }

    public function blocked(){

        $blocked = Build::where('production_stage_id', 4)->count();

        return  $this->sendResponse( $blocked, 'total blocked');

    }

    public function done(){

        $done = Build::where('production_stage_id', 2)->count();

        return  $this->sendResponse( $done, 'total done');

    }

    public function morderCount()
    {
        $morder = manufacturingOrder::count();

        return $this->sendResponse($morder, 'Total manufacturing Order');
    }



  
    
 
    
}
