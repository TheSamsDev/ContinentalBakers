<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function getStores()
    {
        // Fetch all stores with their associated orders and order details
        $user = Auth::user();

    // Fetch stores based on the user's role
      $stores = $user->hasRole('SuperAdmin')
        ? Store::with(['orders.products', 'orders.products.brand'])->get() 
        : Store::with(['orders.products', 'orders.products.brand'])->where('user_id', $user->id)->get();


        $storesWithOrderDetails = $stores->map(function ($store) {
            $storeData = $store->toArray();
            $storeData['orders'] = $store->orders->map(function ($order) {
                return $order->products->map(function ($product) use ($order) {
                    return [
                        'brand_name' => $product->brand->name,
                        'quantity' => $product->pivot->quantity,
                        'total_price' => $product->pivot->total_price,
                        'order_date' => $order->pivot->order_date,
                        'state' => $product->pivot->state,
                    ];
                });
            });

            return $storeData;
        });

        // Return the stores with their order information
        return response()->json($storesWithOrderDetails);
    }
}
