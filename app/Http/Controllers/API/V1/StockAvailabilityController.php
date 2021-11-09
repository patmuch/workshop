<?php


namespace App\Http\Controllers\API\V1;

use App\Models\StockAvailability;


class StockAvailabilityController extends BaseController
{
    protected $status = '';

  
    public function __construct(StockAvailability $status)
    {
        $this->middleware('auth:api');
        $this->status = $status;
    }

  
    public function index()
    {
        $statuses =  $this->status->latest()->paginate(10);
        return $this->sendResponse($statuses, 'AvailabilityStatus list');
    }

    public function list()
    {
        $statuses =  $this->status->pluck('name', 'id');;
        return $this->sendResponse($statuses, 'AvailabilityStatus list');
    }


    public function destroy($status)
    {
        $this->authorize('isAdmin');

        $statuses = $this->status->findOrFail($status);

        $statuses->delete();

        return $this->sendResponse($statuses, 'Availability status has been Deleted');
    }
}
