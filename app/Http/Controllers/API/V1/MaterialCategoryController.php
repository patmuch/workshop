<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\MaterialCategory;



class MaterialCategoryController extends BaseController
{
    protected $materialCategory = '';

    
    public function __construct(MaterialCategory $materialCategory)
    {
        $this->middleware('auth:api');
        $this->materialCategory = $materialCategory;
    }

 
    public function index()
    {
        $materialCategories = $this->materialCategory->latest()->paginate(10);
        return $this->sendResponse($materialCategories, 'MaterialCategory list');
    }

     
    
    public function list()
    {
        $materialCategories = $this->materialCategory->pluck('name', 'id');

        return $this->sendResponse($materialCategories, 'MaterialCategory list');
    }


    public function store(Request $request)
    {
        $tag = $this->materialCategory->create([
            'name' => $request->get('name'),    
        ]);

        return $this->sendResponse($tag, 'MaterialCategory Created Successfully');
    }

  
    public function update(Request $request, $materialCategory)
    {
        $tag = $this->materialCategory->findOrFail($materialCategory);

        $tag->update($request->get('name'));

        return $this->sendResponse($tag, 'MaterialCategory has been updated');
    }

    
    public function updateCategory(Request $request, $materialCategory)
    {
        $tag = $this->materialCategory->findOrFail($materialCategory);

        $tag->update($request->all());
        

        return $this->sendResponse($tag, 'MaterialCategory has been updated');
    }
}
