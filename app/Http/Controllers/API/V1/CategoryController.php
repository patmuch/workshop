<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    protected $category = '';


    public function __construct(Category $category)
    {
        $this->middleware('auth:api');
        $this->category = $category;
    }


 
    public function index()
    {
        $categories = $this->category->latest()->paginate(10);

        return $this->sendResponse($categories, 'Category list');
    }

   
    public function list()
    {
        $categories = $this->category->pluck('name', 'id');

        return $this->sendResponse($categories, 'Category list');
    }


  
    public function store(Request $request)
    {
        $tag = $this->category->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->sendResponse($tag, 'Category Created Successfully');
    }

   
    public function update(Request $request, $id)
    {
        $tag = $this->category->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Category Information has been updated');
    }
}
