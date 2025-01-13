<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getAvailableYears()
{
    // Get distinct years from the order_date column
    $years = DB::table('order_product')
        ->select(DB::raw('DISTINCT YEAR(order_date) as year'))
        ->orderByDesc('year')
        ->pluck('year');

    // Return years as JSON
    return response()->json($years);
}

public function getGrowthData(Request $request)
{
    $selectedYear = $request->input('year', date('Y'));

    // Total sales for the selected year
    $currentYearSales = DB::table('order_product')
        ->whereYear('order_date', $selectedYear)
        ->sum('total_price');

    // Previous year's total sales
    $previousYearSales = DB::table('order_product')
        ->whereYear('order_date', $selectedYear - 1)
        ->sum('total_price');

    // Monthly sales for the selected year
    $monthlySales = DB::table('order_product')
        ->select(DB::raw('MONTH(order_date) as month'), DB::raw('SUM(total_price) as sales'))
        ->whereYear('order_date', $selectedYear)
        ->groupBy(DB::raw('MONTH(order_date)'))
        ->pluck('sales', 'month');

    // Fill missing months with 0 sales
    $monthlySalesArray = array_fill(1, 12, 0); // Initialize all months with 0
    foreach ($monthlySales as $month => $sales) {
        $monthlySalesArray[$month] = $sales;
    }

    // Calculate percentage growth
    $growthPercentage = $previousYearSales > 0
        ? (($currentYearSales - $previousYearSales) / $previousYearSales) * 100
        : 0;

    return response()->json([
        'currentYear' => $selectedYear,
        'currentYearSales' => $currentYearSales,
        'previousYearSales' => $previousYearSales,
        'growthPercentage' => round($growthPercentage, 2),
        'monthlySales' => array_values($monthlySalesArray), // Return sales as an array
    ]);
}

    public function getStoreData(Request $request)
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
        DB::raw('MAX(order_product.order_date) as last_order_date')
    )
    ->join('order_product', 'stores.id', '=', 'order_product.store_id')
    ->groupBy('stores.id', 'stores.name') // Group by both store id and name
    ->orderByDesc(DB::raw('SUM(order_product.total_price)')) // Order by total sales descending
    ->take(3) // Fetch top 3 stores
    ->get();


// dd($topStore);

// Fetch all stores with their last order date
$allStores = DB::table('stores')
    ->join('order_product', 'stores.id', '=', 'order_product.store_id')
    ->select(
        'stores.name as store_name',
        DB::raw('SUM(order_product.total_price) as total_sales'),
        DB::raw('MAX(order_product.order_date) as last_order_date')
    )
    ->groupBy('stores.id', 'stores.name')
    ->havingRaw('MAX(order_product.order_date) <= ?', [Carbon::now()->subMonths(2)])
    ->get();
// dd($allStores);

 // Fetch stores
 $stores = DB::table('stores')->get();

 $monthlySales = DB::table('order_product')
 ->select(
     DB::raw('MONTH(order_date) as month'),
     DB::raw('YEAR(order_date) as year'),
     DB::raw('SUM(total_price) as total_sales')
 )
 ->groupBy('year', 'month')
 ->orderBy('year')
 ->orderBy('month')
 ->get();

// Ensure all months are included in the chart, even if missing in the database
$allMonths = collect(range(1, 12));
$currentYear = date('Y');

// Fill missing months with zero sales
$salesData = $allMonths->mapWithKeys(function ($month) use ($monthlySales, $currentYear) {
 $monthSales = $monthlySales->firstWhere('month', $month);
 return [sprintf('%02d/%d', $month, $currentYear) => $monthSales->total_sales ?? 0];
});

    // Pass data to the view
    return view('dashboard', [
        'topBrands' => $topBrands,
        'overallSales' => $overallSales,
        'topProducts' => $topProducts,
        'topStore' => $topStore,
        'allStores' => $allStores,
        'stores' => $stores,
        'salesData' => $salesData,
        

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
