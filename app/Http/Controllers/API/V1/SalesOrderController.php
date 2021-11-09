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

    public function create()
    {
        $sorder_prefix = 'SO';
        $order_num_auto_generate = 'True';

        $nextOrderNumberAttribute = null;
        $nextOrderNumber = SalesOrder::getNextOrderNumber($sorder_prefix);

        if ($order_num_auto_generate == 'True') {
            $nextOrderNumberAttribute = $nextOrderNumber;
        }
   
        return response()->json([
            'nextOrderNumberAttribute' => $nextOrderNumberAttribute,
            'nextOrderNumber' => $sorder_prefix.'-'.$nextOrderNumber,
            'sorder_prefix' => $sorder_prefix
        ]);
    }

    

  
    public function store(Request $request)
    {

        
        $sorder_number = explode( "-", $request->order_id );
        $number_attributes['sorder_number'] = $sorder_number[0].'-'.sprintf('%06d', intval($sorder_number[1]));

        Validator::make($number_attributes, [
           'sorder_number' => 'required|unique:sales_orders,sorder_number'
        ])->validate();
     
        $sorder_date = Carbon::parse($request->order_date)->format('d/m/Y');
       // $sorder_date = Carbon::createFromFormat('d/m/Y', $request->order_date);

        $delivery_deadline = Carbon::parse($request->delivery_deadline)->format('d/m/Y');
        //$delivery_deadline = Carbon::createFromFormat('d/m/Y', $request->delivery_deadline);

        $salesOrder = $this->salesOrder->create([

            'sorder_number'      =>    $number_attributes['sorder_number'],
            'sorder_date'        =>    $sorder_date,
            'customer_id'        =>    $request->get('customer_id'),
            'product_id'         =>    $request->get('product_id'),
            'delivery_deadline'  =>    $delivery_deadline,
            'order_status_id'    =>    $request->get('status_id'),
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
