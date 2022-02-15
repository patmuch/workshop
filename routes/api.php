<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});

Route::get('profile', 'API\V1\ProfileController@profile');
Route::put('profile', 'API\V1\ProfileController@updateProfile');
//to revisit this route after app is done
Route::put('materialCat/{materialCategory}', 'API\V1\MaterialCategoryController@updateCategory');
Route::put('materialUpdate/{material}', 'API\V1\MaterialController@updateMat');
Route::delete('materialDel/{material}', 'API\V1\MaterialController@destroyMat');

Route::put('contact/{contact}', 'API\V1\ContactController@update');
Route::delete('contact/{contact}', 'API\V1\ContactController@destroy');

Route::put('customer/{customer}', 'API\V1\CustomerController@update');
Route::delete('customer/{customer}', 'API\V1\CustomerController@destroy');

Route::put('supplier/{supplier}', 'API\V1\SupplierController@update');
Route::delete('supplier/{supplier}', 'API\V1\SupplierController@destroy');

Route::post('change-password', 'API\V1\ProfileController@changePassword');
Route::get('tag/list', 'API\V1\TagController@list');
Route::get('category/list', 'API\V1\CategoryController@list');
Route::get('uom/list', 'API\V1\UomController@list');

Route::get('supplier/list', 'API\V1\SupplierController@list');
Route::get('supplier/all', 'API\V1\SupplierController@fetchAll');

Route::get('customer/list', 'API\V1\CustomerController@list');
Route::get('product/list', 'API\V1\ProductController@list');
Route::get('user/list', 'API\V1\UserController@list');


Route::get('availability/list', 'API\V1\StockAvailabilityController@list');
Route::get('status/list', 'API\V1\ProductionStageController@list');
Route::get('orderStatus/list', 'API\V1\OrderStatusController@list');
Route::get('contactType/list', 'API\V1\ContactTypeController@list');
Route::get('paymentType/list', 'API\V1\PaymentTypeController@list');
Route::get('materialCategory/list', 'API\V1\MaterialCategoryController@list');
Route::get('material/list', 'API\V1\MaterialController@list');

Route::get('materialFetch/{id}', 'API\V1\MaterialController@fetch');
Route::get('material/all', 'API\V1\MaterialController@fetchAll');

Route::get('create/sorder', 'API\V1\SalesOrderController@create');
Route::get('salesOrder/all', 'API\V1\SalesOrderController@fetchAll');

Route::get('create/morder', 'API\V1\ManufacturingOrderController@create');

Route::get('build/order', 'API\V1\BuildController@getBuilds');

Route::post('build/material', 'API\V1\BuildController@storeRecipe');

Route::get('wip/material/{id}', 'API\V1\BuildController@wipMaterial');

Route::get('manufacturingOrder/all', 'API\V1\ManufacturingOrderController@fetchAll');

Route::post('product/upload', 'API\V1\ProductController@upload');

Route::post('receive/material', 'API\V1\ReceiveController@store');

Route::get('search', 'API\V1\MaterialController@search');

Route::get('dashboard/customer', 'API\V1\DashboardController@customer');
Route::get('dashboard/sorder', 'API\V1\DashboardController@salesOrder');
Route::get('dashboard/morder', 'API\V1\DashboardController@manufacturingOrder');
Route::get('dashboard/corder', 'API\V1\DashboardController@customerOrder');
Route::get('dashboard/wip', 'API\V1\DashboardController@workInProgess');
Route::get('dashboard/production', 'API\V1\DashboardController@productionCount');
Route::get('dashboard/blocked', 'API\V1\DashboardController@blocked');
Route::get('dashboard/done', 'API\V1\DashboardController@done');
Route::get('dashboard/stock', 'API\V1\DashboardController@stock');
Route::get('dashboard/morderCount', 'API\V1\DashboardController@morderCount');

Route::apiResources([
    'user'     =>            'API\V1\UserController',
    'contact'  =>            'API\V1\ContactController',
    'build'    =>            'API\V1\BuildController',
    'status'   =>            'API\V1\ProductionStageController',
    'customer' =>            'API\V1\CustomerController',
    'supplier' =>            'API\V1\SupplierController',
    'product'  =>            'API\V1\ProductController',
    'material' =>            'API\V1\MaterialController',
    'materialCategory' =>    'API\V1\MaterialCategoryController',
    'manufacturingOrder' =>  'API\V1\ManufacturingOrderController',
    'salesOrder' =>          'API\V1\SalesOrderController',
    'category' =>            'API\V1\CategoryController',
    'uom'      =>            'API\V1\UomController',
    'tag'      =>            'API\V1\TagController',
]);

    