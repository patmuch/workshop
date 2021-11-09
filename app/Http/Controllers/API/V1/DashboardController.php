<?php


namespace App\Http\Controllers\API\V1;
use App\Models\Customer;
use App\Models\Build;
use App\Models\Supplier;
use App\Models\ManufacturingOrder;
use App\Models\SalesOrder;
use App\Models\Product;

class DashboardController extends BaseController
{
   

  
    public function __construct()
    {
        $this->middleware('auth:api');
      
    }

  
    public function index()
    {
        $customers =  $this->customer->latest()->paginate(10);
        return $this->sendResponse($customers, 'Customers list');
    }

    public function list()
    {
        $customers = $this->customer->pluck('fname', 'id');

        return $this->sendResponse($customers, 'Customers list');
    }

    public function customers()
    {
        $customers = $this->customer->pluck('fname', 'id');

        return $this->sendResponse($customers, 'Customers list');
    }

    public function suppliers()
    {
        $customers = $this->customer->pluck('fname', 'id');

        return $this->sendResponse($customers, 'Customers list');
    }

    public function builds()
    {
        $customers = $this->customer->pluck('fname', 'id');

        return $this->sendResponse($customers, 'Customers list');
    }

    public function salesOrders()
    {
        $customers = $this->customer->pluck('fname', 'id');

        return $this->sendResponse($customers, 'Customers list');
    }

    public function manufacturingOrders()
    {
        $customers = $this->customer->pluck('fname', 'id');

        return $this->sendResponse($customers, 'Customers list');
    }

  
    
 
    
}
