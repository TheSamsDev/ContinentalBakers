<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function getStores()
    {
        // Fetch all stores from the database
        $stores = Store::all();

        // Return the stores as a JSON response
        return response()->json($stores);
    }
}
