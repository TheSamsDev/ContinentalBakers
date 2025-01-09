<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view store', ['only' => ['index']]);
        $this->middleware('permission:create store', ['only' => ['create','store']]);
        $this->middleware('permission:update store', ['only' => ['update','edit']]);
        $this->middleware('permission:delete store', ['only' => ['destroy']]);
    }

    public function index()
    {  
        if(auth()->user()->hasAnyRole(['SuperAdmin','SuperVisor'])){
            $stores = Store::get(); 

        }else{
            $stores = Store::where('user_id', auth()->id())->get(); 

        }
        return view('dashboard.store.index', compact('stores'));
    }

    public function create()
    {
        return view('dashboard.stores.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'mainaddress' => 'required|string|max:255',
    ]);

    Store::create([
        'name' => $request->name,
        'address' => $request->address,
        'mainaddress' => $request->mainaddress, 
        'user_id' => auth()->id(),  
    ]);

    session()->flash('success', 'Store added successfully');

    return redirect()->route('stores.index');
}


    public function edit(Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return redirect()->route('stores.index')->with('error', 'Unauthorized action');
        }

        return view('dashboard.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return redirect()->route('stores.index')->with('error', 'Unauthorized action');
        }
    
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mainaddress' => 'required|string|max:255',
        ]);
    
        $store->update([
            'name' => $request->name,
            'address' => $request->address,
            'mainaddress' => $request->mainaddress, 
        ]);
    
        return redirect()->route('stores.index')->with('success', 'Store updated successfully');
    }

    // Delete the store
    public function destroy(Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return redirect()->route('stores.index')->with('error', 'Unauthorized action');
        }

        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Store deleted successfully');
    }
}
