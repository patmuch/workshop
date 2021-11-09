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

    public function create(Request $request)
    {
        
        $morder_prefix = 'MO';
        $order_num_auto_generate = 'True';

        $nextOrderNumberAttribute = null;
        $nextOrderNumber = ManufacturingOrder::getNextOrderNumber($morder_prefix);

        if ($order_num_auto_generate == 'True') {
            $nextOrderNumberAttribute = $nextOrderNumber;
        }

        return response()->json([
            'nextOrderNumberAttribute' => $nextOrderNumberAttribute,
            'nextOrderNumber' => $morder_prefix.'-'.$nextOrderNumber,
            'morder_prefix' => $morder_prefix
        ]);
    }

  
    public function store(Request $request)
    {
        $morder_number = explode("-",$request->order_id);
        $number_attributes['morder_number'] = $morder_number[0].'-'.sprintf('%06d', intval($morder_number[1]));

        Validator::make($number_attributes, [
            'morder_number' => 'required|unique:manufacturing_orders,morder_number'
        ])->validate();

       //$morder_date = Carbon::createFromFormat('d/m/Y', $request->order_date);
       
        $morder_date = Carbon::parse($request->order_date)->format('d/m/Y');

       //$production_deadline = Carbon::createFromFormat('d/m/Y', $request->production_deadline);

       $production_deadline = Carbon::parse($request->production_deadline)->format('d/m/Y');

     
        
        $manufacturingOrder = $this->manufacturingOrder->create([

        'morder_number' => $number_attributes['morder_number'],
        'morder_date' => $morder_date,
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
