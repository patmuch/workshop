<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\MaterialCategory;



class MaterialCategoryController extends BaseController
{
    protected $materialCategory = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MaterialCategory $materialCategory)
    {
        $this->middleware('auth:api');
        $this->materialCategory = $materialCategory;
    }

    //
    public function index()
    {
        $materialCategories = $this->materialCategory->latest()->paginate(10);
        return $this->sendResponse($materialCategories, 'MaterialCategory list');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function list()
    {
        $materialCategories = $this->materialCategory->pluck('name', 'id');

        return $this->sendResponse($materialCategories, 'MaterialCategory list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tag = $this->materialCategory->create([
            'name' => $request->get('name'),    
        ]);

        return $this->sendResponse($tag, 'MaterialCategory Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
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
