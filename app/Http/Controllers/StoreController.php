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

    // Show the list of stores for the logged-in user
    public function index()
    {  
        if(auth()->user()->hasAnyRole(['SuperAdmin','SuperVisor'])){
            $stores = Store::get(); 

        }else{
            $stores = Store::where('user_id', auth()->id())->get(); 

        }
        return view('dashboard.store.index', compact('stores'));
    }

    // Show the form to create a new store
    public function create()
    {
        return view('dashboard.stores.create');
    }

    // Store the new store in the database
    public function store(Request $request)
{
    // Validate the inputs, including 'mainaddress'
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'mainaddress' => 'required|string|max:255',
    ]);

    // Create the store with the 'mainaddress' field included
    Store::create([
        'name' => $request->name,
        'address' => $request->address,
        'mainaddress' => $request->mainaddress, 
        'user_id' => auth()->id(),  
    ]);

    session()->flash('success', 'Store added successfully');

    return redirect()->route('stores.index');
}


    // Show the form to edit the store
    public function edit(Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return redirect()->route('stores.index')->with('error', 'Unauthorized action');
        }

        return view('dashboard.stores.edit', compact('store'));
    }

    // Update the store information
    public function update(Request $request, Store $store)
    {
        if ($store->user_id !== auth()->id()) {
            return redirect()->route('stores.index')->with('error', 'Unauthorized action');
        }
    
        // Validate the inputs, including 'mainaddress'
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mainaddress' => 'required|string|max:255',
        ]);
    
        // Update the store with the new information, including 'mainaddress'
        $store->update([
            'name' => $request->name,
            'address' => $request->address,
            'mainaddress' => $request->mainaddress,  // Update the main address
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
