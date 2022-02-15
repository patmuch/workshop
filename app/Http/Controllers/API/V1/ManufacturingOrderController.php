<?php

namespace App\Http\Controllers\API\V1;

use App\Models\ManufacturingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ManufacturingOrderController extends BaseController
{
    
    protected $manufacturingOrder = '';

    public function __construct(ManufacturingOrder $manufacturingOrder)
    {
        $this->middleware('auth:api');
        $this->manufacturingOrder = $manufacturingOrder;
    }

  
    public function index()
    {
        $manufacturingOrder =  $this->manufacturingOrder->latest()->with('product')->paginate(10);
        return $this->sendResponse($manufacturingOrder, 'Manufacturing Order list');
    }

    public function fetchAll()
    {
        $manufacturingOrder =  $this->manufacturingOrder->all();
        return $this->sendResponse($manufacturingOrder, 'Manufacturing Orders ');
    }

    public function create(Request $request)
    {
        
        $order_prefix = 'MO';
        $order_num_auto_generate = 'True';

        $nextOrderNumberAttribute = null;
        $nextOrderNumber = ManufacturingOrder::getNextOrderNumber($order_prefix);

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
        $order_number = explode("-",$request->order_number);
        $number_attributes['order_number'] = $order_number[0].'-'.sprintf('%06d', intval($order_number[1]));

        Validator::make($number_attributes, [
            'order_number' => 'required|unique:manufacturing_orders,order_number'
        ])->validate();

       //$morder_date = Carbon::createFromFormat('d/m/Y', $request->order_date);
       
        $order_date = Carbon::parse($request->order_date)->format('d/m/Y');

       //$production_deadline = Carbon::createFromFormat('d/m/Y', $request->production_deadline);

       $production_deadline = Carbon::parse($request->production_deadline)->format('d/m/Y');

     
        
        $manufacturingOrder = $this->manufacturingOrder->create([

        'order_number' => $number_attributes['order_number'],
        'order_date' => $order_date,
        'product_id' => $request->get('product_id'),
        'production_deadline' => $production_deadline,
        
        ]);

        return $this->sendResponse($manufacturingOrder, 'Manufacturing Order Created Successfully');

        
    }



 
    public function update(Request $request, $manufacturingOrder)
    {
        

        $manufacturingOrder = $this->manufacturingOrder->findOrFail($manufacturingOrder);

        $manufacturingOrder->update($request->all());
                
        return $this->sendResponse($manufacturingOrder, 'Order Information has been updated');

        
    }

 
    public function destroy($manufacturingOrder)
    {
        $this->authorize('isAdmin');

        $manufacturingOrder = $this->manufacturingOrder->findOrFail($manufacturingOrder);

        $manufacturingOrder->delete();

        return $this->sendResponse($manufacturingOrder, 'Manufacturing Order has been Deleted');
    }

    
}
