<?php


namespace App\Http\Controllers\API\V1;

use App\Models\OrderStatus;


class OrderStatusController extends BaseController
{
    protected $status = '';

  
    public function __construct(OrderStatus $status)
    {
        $this->middleware('auth:api');
        $this->status = $status;
    }

  
    public function index()
    {
        $statuses =  $this->status->latest()->paginate(10);
        return $this->sendResponse($statuses, 'Order Status list');
    }

    public function list()
    {
        $statuses =  $this->status->pluck('name', 'id');;
        return $this->sendResponse($statuses, 'Order Status list');
    }


    public function destroy($status)
    {
        $this->authorize('isAdmin');

        $statuses = $this->status->findOrFail($status);

        $statuses->delete();

        return $this->sendResponse($statuses, 'Order status has been Deleted');
    }
}
