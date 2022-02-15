<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Contacts\CustomerRequest;

use App\Models\Customer;



class CustomerController extends BaseController
{
    protected $customer = '';

  
    public function __construct(Customer $customer)
    {
        $this->middleware('auth:api');
        $this->customer = $customer;
    }

  
    public function index()
    {
        $customers =  $this->customer->latest()->paginate(10);
        return $this->sendResponse($customers, 'Customers list');
    }

    public function list()
    {
        $customers = $this->customer->all();

        return $this->sendResponse($customers, 'Customers list');
    }

  
    public function store(CustomerRequest $request)
    {
     
        
        $customers = $this->customer->create([

        'fname' => $request->get('fname'),
        'lname' => $request->get('lname'),
        'email' => $request->get('email'),
        'phone' => $request->get('phone'),
        ]);

        return $this->sendResponse($customers, 'Customer Created Successfully');

        
    }



 
    public function update(CustomerRequest $request, $customer)
    {
        

        $customers = $this->customer->findOrFail($customer);

        $customers->update($request->all());
                
        return $this->sendResponse($customers, 'Customer Information has been updated');

        
    }

 
    public function destroy($customer)
    {
        $this->authorize('isAdmin');

        $customers = $this->customer->findOrFail($customer);

        $customers->delete();

        return $this->sendResponse($customers, 'Customer has been Deleted');
    }
}
