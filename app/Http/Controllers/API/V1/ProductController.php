<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Products\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    protected $product = '';

 
    public function __construct(Product $product)
    {
        $this->middleware('auth:api');
        $this->product = $product;
    }

    
    public function index()
    {
        $products = $this->product->latest()->with('category', 'stockAvailability')->paginate(10);

        return $this->sendResponse($products, 'Product list');
    }

    public function list()
    {
        $products = $this->product->pluck('name', 'id');

        return $this->sendResponse($products, 'Products list');
    }


    public function store(ProductRequest $request)
    {
        $product = $this->product->create([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'stock_availability_id' => $request->get('stock_availability_id'),
            'category_id' => $request->get('category_id'),
        ]);


        return $this->sendResponse($product, 'Product Created Successfully');
    }

  
    public function show($id)
    {
        $product = $this->product->with(['category', 'tags'])->findOrFail($id);

        return $this->sendResponse($product, 'Product Details');
    }

   
    public function update(ProductRequest $request, $id)
    {
        $product = $this->product->findOrFail($id);

        $product->update($request->all());

        return $this->sendResponse($product, 'Product Information has been updated');
    }

    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $product = $this->product->findOrFail($id);

        $product->delete();

        return $this->sendResponse($product, 'Product has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
