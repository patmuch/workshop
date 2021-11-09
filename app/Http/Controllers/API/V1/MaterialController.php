<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Materials\MaterialRequest;
use Illuminate\Http\Request;


use App\Models\Material;



class MaterialController extends BaseController
{

    protected $material = '';

    
    public function __construct(Material $material)
    {
        $this->middleware('auth:api');
        $this->material = $material;
    }


    public function index()
    {
        $materials =  $this->material->latest()->with('materialCategory','uom')->paginate(10);
        return $this->sendResponse($materials, 'Material list');
    }
    

    public function list()
    {
        $materials =  $this->material->pluck('material_name', 'id');
        return $this->sendResponse($materials, 'material list');
    }


    public function store(MaterialRequest $request)
    {
        $material = $this->material->create([
            'material_name' => $request->get('material_name'),
            'material_code' => $request->get('material_code'),
            'description'   => $request->get('description'),
            'reorder_level' => $request->get('reorder_level'),
            'costprice'     => $request->get('costprice'),
            'quantity'      => $request->get('quantity'),
            'material_category_id' => $request->get('material_category_id'),
            'uom_id' => $request->get('uom_id'),
        ]);
        
           $movement_id =   $request->get('movement_id');

        $material->movements()->attach($movement_id,[ 'quantity' => $request->get('quantity')]);

        return $this->sendResponse($material, 'material Created Successfully');
    }

    public function search(Request $request){

        // Get the search value from the request
        $search = $request->input('search');
    
        // Search in the title and body columns from the posts table
         $material = Material::query()
            ->where('material_name', 'LIKE', "%{$search}%")
            ->orWhere('material_code', 'LIKE', "%{$search}%")
            ->get();
    
        // Return the search view with the resluts compacted
       
        return $this->sendResponse($material, 'Searched material');
    }

   
    public function fetch($id)
    {
        $material = $this->material->findOrFail($id);

        return $this->sendResponse($material, 'material profile');
    }

       
    public function fetchAll()
    {
        $material = $this->material->all();

        return $this->sendResponse($material, 'materials');
    }

 
    public function updateMat(MaterialRequest $request, $material)
    {
        $mat = $this->material->findOrFail($material);

        $mat->update($request->all());
                
        return $this->sendResponse($mat, 'material Information has been updated');
    }

  
    public function destroyMat($material)
    {

        $this->authorize('isAdmin');

        $mat = $this->material->findOrFail($material);

        $mat->delete();

        return $this->sendResponse($mat, 'material has been Deleted');
    }


   
}
