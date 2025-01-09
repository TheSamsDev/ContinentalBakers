<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'state' => 'required|string',
            'store_id' => 'required|exists:stores,id',
        ]);
    
        $product = Product::findOrFail($request->product_id);
        
        // Create an order entry
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'confirmed',
        ]);
    
        // Attach the product with additional pivot data (state, store_id)
        $order->products()->attach($request->product_id, [
            'brand_id' => $product->brand_id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'store_id' => $request->store_id,  // Storing store_id in pivot
            'state' => $request->state,  // Storing state in pivot
            'order_date' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Order placed successfully!');
    }
    

    public function index()
    {
        // Check if the user is a super admin
        if (auth()->user()->hasRole('SuperAdmin')) {
            // Super admin can see all orders
            $orders = Order::with('products.brand')->get();
            // dd($orders);
        } else {
            // Regular user can only see their own orders
            $orders = auth()->user()->orders()->with('products.brand')->get();
        }

        return view('order.index', compact('orders'));
    }
    
}
