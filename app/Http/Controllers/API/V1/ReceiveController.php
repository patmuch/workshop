<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\Receive;

class ReceiveController extends BaseController
{
    protected $receive = '';

    public function __construct(Receive $receive)
    {
        $this->middleware('auth:api');
        $this->receive = $receive;
    }




    public function store(Request $request)
    {
        $receive = $this->receive->create([
            'supplier_id'      =>     $request->get('supplier_id'),
            'purchase_order'   =>     $request->get('purchase_order'),
            'user_id'          =>     $request->get('user_id'),
           
           
            'grandtotal'       =>     $request->get('grandtotal'),
          
        ]);

        // update pivot table
        $material_ids = [];
        foreach ($request->get('material_id') as $material) {
            $material_ids[] = $material['id'];
        }
       
        $receive->materials()->sync($material_ids);

        return $this->sendResponse($receive, 'Material received Successfully');
    }



   
    public function update(Request $request, $id)
    {
        $receive = $this->receive->findOrFail($id);

        $receive->update($request->all());

        // update pivot table
        $material_ids = [];
        foreach ($request->get('material_id') as $material) {
            $material_ids[] = $material['id'];
        }
        $receive->tags()->sync($material_ids);

        return $this->sendResponse($receive, 'Receiving Information has been updated');
    }

   

    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $product = $this->product->findOrFail($id);

        $product->delete();

        return $this->sendResponse($product, 'Product has been Deleted');
    }

  
    


}
