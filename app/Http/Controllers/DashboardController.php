<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{public function getStoreData(Request $request)
    {
        $storeId = $request->store_id;
    
        // Query for monthly revenue and order count for the selected store
        $data =  DB::table('order_product')->where('store_id', $storeId)
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_revenue, COUNT(id) as total_orders')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();
    
        // Return data as JSON
        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  

 // Fetch top products
 $topProducts = DB::table('order_product')
     ->join('products', 'order_product.product_id', '=', 'products.id')
     ->select(
         'products.name as product_name',
         'products.image',
         DB::raw('SUM(order_product.quantity) as total_quantity'),
         DB::raw('SUM(order_product.total_price) as total_sales')
     )
     ->groupBy('products.id', 'products.name','products.image')
     ->orderByDesc('total_sales')
     ->limit(5)
     ->get();
        // Fetch top 5 brands with their total sales, total orders, and products
        $topBrands = DB::table('order_product')
            ->join('brands', 'order_product.brand_id', '=', 'brands.id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->select(
                'brands.name as brand_name',
                'brands.logo',
                DB::raw('SUM(order_product.total_price) as total_sales'),
                DB::raw('COUNT(order_product.id) as total_orders'),
                DB::raw('GROUP_CONCAT(DISTINCT products.name SEPARATOR ", ") as product_names')
            )
            ->groupBy('brands.name', 'brands.logo') // Include brand_logo in GROUP BY
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();
    
        // Fetch overall sales data
        $overallSales = DB::table('order_product')
            ->select(DB::raw('SUM(total_price) as total_sales'), DB::raw('COUNT(id) as total_orders'))
            ->first();
    // Fetch the top store with the highest order amount
// Fetch the last order date and total sales for the top store
// Fetch the top store with the highest order amount
$topStore = DB::table('stores')
    ->select(
        'stores.name as store_name', 
        DB::raw('SUM(order_product.total_price) as total_sales'),
        DB::raw('MAX(order_product.created_at) as last_order_date')
    )
    ->join('order_product', 'stores.id', '=', 'order_product.store_id')
    ->groupBy('stores.id', 'stores.name')  // Group by both store id and name
    ->orderByDesc(DB::raw('SUM(order_product.total_price)'))  // Order by the total sales
    ->limit(1)
    ->first();



// Fetch all stores with their last order date
$allStores = DB::table('stores')
->join('order_product', 'stores.id', '=', 'order_product.store_id')
->select('stores.name as store_name',DB::raw('SUM(order_product.total_price) as total_sales'), DB::raw('MAX(order_product.order_date) as last_order_date'))

->groupBy('stores.id', 'stores.name')  // Added stores.name to GROUP BY
->get();
// dd($allStores);

 // Fetch stores
 $stores = DB::table('stores')->get();

 // Fetch order and revenue data by month for each store
 $revenueAndOrders = DB::table('order_product')
     ->select(
         DB::raw('MONTH(order_product.created_at) as month'),
         DB::raw('YEAR(order_product.created_at) as year'),
         'stores.name as store_name',
         DB::raw('SUM(order_product.total_price) as total_revenue'),
         DB::raw('COUNT(order_product.id) as total_orders')
     )
     ->join('stores', 'stores.id', '=', 'order_product.store_id')
     ->groupBy(DB::raw('MONTH(order_product.created_at)'), DB::raw('YEAR(order_product.created_at)'), 'stores.id', 'stores.name')
     ->orderBy(DB::raw('YEAR(order_product.created_at)'), 'ASC')
     ->get();
    // Pass data to the view
    return view('dashboard', [
        'topBrands' => $topBrands,
        'overallSales' => $overallSales,
        'topProducts' => $topProducts,
        'topStore' => $topStore,
        'allStores' => $allStores,
        'stores' => $stores,
        'revenueAndOrders' => $revenueAndOrders
    ]);
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
