<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // dd("aa");
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'store_id' => 'required|exists:stores,id',
        ]);
     
        $product = Product::findOrFail($request->product_id);
        $order_state=Store::findOrFail($request->store_id);
        // dd($order_state);
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'confirmed',
        ]);
    
        $order->products()->attach($request->product_id, [
            'brand_id' => $product->brand_id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'store_id' => $request->store_id, 
            'state' => $order_state->state, 
            'order_date' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Order placed successfully!');
    }
    

    public function index()
    {
        if (auth()->user()->hasRole('SuperAdmin')) {
            $orders = Order::with('products.brand')->get();
        } else {
            $orders = auth()->user()->orders()->with('products.brand')->get();
        }

        return view('order.index', compact('orders'));
    }
    
}
