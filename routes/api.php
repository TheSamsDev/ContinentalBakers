<?php

use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::post('/login', "UserController@login");

    Route::group(['middleware' => 'auth:sanctum'],function(){
        Route::resource('user', 'UserController');
    });
    
    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/stores', [StoreController::class, 'getStores']);
    Route::get('/brand-details', function (Request $request) {
        $brandName = $request->query('brand');
    
        // Fetch stores and their products for the brand
        $stores = DB::table('stores')
        ->join('order_product', 'stores.id', '=', 'order_product.store_id')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
        ->select(
            'stores.name as name',
            'stores.mainaddress as location',
            'products.name as product_name',
            'products.image as product_image',
            DB::raw('SUM(order_product.quantity) as total_orders') // Aggregate total orders for each product
        )
        ->where('brands.name', $brandName)
        ->groupBy('products.name', 'products.image', 'stores.name', 'stores.mainaddress')
        ->get();
    
    
        return response()->json([
            'stores' => $stores,
        ]);
    });
    
});


