<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Contacts\SupplierRequest;

use App\Models\Supplier;



class SupplierController extends BaseController
{
    protected $supplier = '';

  
    public function __construct(Supplier $supplier)
    {
        $this->middleware('auth:api');
        $this->supplier = $supplier;
    }

  
    public function index()
    {
        $suppliers =  $this->supplier->latest()->paginate(10);
        return $this->sendResponse($suppliers, 'Suppliers list');
    }

    public function list()
    {
        $suppliers = $this->supplier->pluck('fname', 'id');

        return $this->sendResponse($suppliers, 'Suppliers list');
    }

    public function fetchAll()
    {
        $suppliers = $this->supplier->all();

        return $this->sendResponse($suppliers, 'suppliers');
    }


  
    public function store(SupplierRequest $request)
    {
     
        
        $supplier = $this->supplier->create([

        'fname' => $request->get('fname'),
        'lname' => $request->get('lname'),
        'email' => $request->get('email'),
        'phone' => $request->get('phone'),
        ]);

        return $this->sendResponse($supplier, 'Supplier Created Successfully');

        
    }



 
    public function update(SupplierRequest $request, $supplier)
    {
        

        $suppliers = $this->supplier->findOrFail($supplier);

        $suppliers->update($request->all());
                
        return $this->sendResponse($suppliers, 'Supplier Information has been updated');

        
    }

 
    public function destroy($supplier)
    {
        $this->authorize('isAdmin');

        $suppliers = $this->customer->findOrFail($supplier);

        $suppliers->delete();

        return $this->sendResponse($suppliers, 'Supplier has been Deleted');
    }
}
