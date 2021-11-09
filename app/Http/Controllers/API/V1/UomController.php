<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Uom;
use Illuminate\Http\Request;

class UomController extends BaseController
{
    protected $uom = '';


    public function __construct(Uom $uom)
    {
        $this->middleware('auth:api');
        $this->uom = $uom;
    }


 
    public function index()
    {
        $uoms = $this->uom->latest()->paginate(10);

        return $this->sendResponse($uoms, 'Uom list');
    }

   
    public function list()
    {
        $uoms = $this->uom->pluck('name', 'id');

        return $this->sendResponse($uoms, 'Uom list');
    }


  
    public function store(Request $request)
    {
        $uom = $this->uom->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->sendResponse($uom, 'Unit of measure Created Successfully');
    }

   
    public function update(Request $request, $id)
    {
        $uom = $this->uom->findOrFail($id);

        $uom->update($request->all());

        return $this->sendResponse($uom, 'Unit of Measure has been updated');
    }
}
