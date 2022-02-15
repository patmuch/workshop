<?php

namespace App\Http\Controllers\API\V1;

use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SalesOrderController extends BaseController
{

    protected $salesOrder = '';

    public function __construct(SalesOrder $salesOrder)
    {
        $this->middleware('auth:api');
        $this->salesOrder = $salesOrder;
    }

  
    public function index()
    {
        $salesOrder =  $this->salesOrder->latest()->with('customer','product','orderStatus')->paginate(10);
        return $this->sendResponse($salesOrder, 'SalesOrder list');
    }

      
    public function fetchAll()
    {

        $salesOrder =  $this->salesOrder->all();
        return $this->sendResponse($salesOrder, 'SalesOrders');
    }

    public function create()
    {
        $order_prefix = 'SO';
        $order_num_auto_generate = 'True';

        $nextOrderNumberAttribute = null;
        $nextOrderNumber = SalesOrder::getNextOrderNumber($order_prefix);

        if ($order_num_auto_generate == 'True') {
            $nextOrderNumberAttribute = $nextOrderNumber;
        }
   
        return response()->json([
            'nextOrderNumberAttribute' => $nextOrderNumberAttribute,
            'nextOrderNumber' => $order_prefix.'-'.$nextOrderNumber,
            'order_prefix' => $order_prefix
        ]);
    }

    

  
    public function store(Request $request)
    {

        
        $order_number = explode( "-", $request->order_number );
        $number_attributes['order_number'] = $order_number[0].'-'.sprintf('%06d', intval($order_number[1]));

        Validator::make($number_attributes, [
           'order_number' => 'required|unique:sales_orders,order_number'
        ])->validate();
     
        $order_date = Carbon::parse($request->order_date)->format('d/m/Y');
       // $order_date = Carbon::createFromFormat('d/m/Y', $request->order_date);

        $delivery_deadline = Carbon::parse($request->delivery_deadline)->format('d/m/Y');
        //$delivery_deadline = Carbon::createFromFormat('d/m/Y', $request->delivery_deadline);

        $salesOrder = $this->salesOrder->create([

            'order_number'       =>    $number_attributes['order_number'],
            'order_date'         =>    $order_date,
            'customer_id'        =>    $request->get('customer_id'),
            'product_id'         =>    $request->get('product_id'),
            'delivery_deadline'  =>    $delivery_deadline,
            'order_status_id'    =>    $request->get('order_status_id'),
        ]);

        return $this->sendResponse($salesOrder, 'Sales Order Created Successfully');

        
    }


    public function update(Request $request, $salesOrder)
    {
        

        $salesOrder = $this->salesOrder->findOrFail($salesOrder);

        $salesOrder->update($request->all());
                
        return $this->sendResponse($salesOrder, 'Order Information has been updated');

        
    }

 
    public function destroy($salesOrder)
    {
        $this->authorize('isAdmin');

        $salesOrder = $this->salesOrder->findOrFail($salesOrder);

        $salesOrder->delete();

        return $this->sendResponse($salesOrder, 'Sales Order has been Deleted');
    }
}
