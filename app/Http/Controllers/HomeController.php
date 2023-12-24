<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function welcome()
    {
       return view('auth.login');
    }
    public function index()
{
    if (auth::check()) {
        $usertype = Auth::user()->usertype;

        if ($usertype == 'user') {
          $user = Auth::user();
$user_id = $user->id;

// Get the API key for the user
$apiKey = User::where('id', $user_id)->value('api_key');

// Check if the API key is empty
if (empty($apiKey)) {
    return view('user.not-found');
}

// Initialize variables
$page = 1;
$pageSize = 2000;
$allSales = [];

// Pagination loop
do {
    // Construct the API URL with the current page number
    $apiUrl = "https://seller-api.takealot.com/v2/sales?page_number={$page}&page_size={$pageSize}";

    // Make an API request to get sales data for the current page
    $response = Http::withHeaders([
        'Authorization' => $apiKey,
    ])->get($apiUrl);

    // Check if the API request is successful
    if ($response->successful()) {
        // Decode the JSON response
        $data = $response->json();
        
        // Get sales data from the current page
        $pageSales = $data['sales'];

        // Add the sales from the current page to the $allSales array
        $allSales = array_merge($allSales, $pageSales);

        // Increment the page number for the next iteration
        $page++;
    } else {
        // Handle the case where the API request is not successful
        // You may want to log the error or handle it in some other way
        break;
    }

    // Continue looping until there are no more pages
} while (!empty($pageSales));

// Now, $allSales contains all the sales data from all pages

// Initialize variables for categorizing sales
$todaySales = [];
$yesterdaySales = [];
$thisMonthSales = [];
$lastMonthSales = [];

$todayTotalSalePrice = 0;
$yesterdayTotalSalePrice = 0;
$thisMonthTotalSalePrice = 0;
$lastMonthTotalSalePrice = 0;

// Get current dates for comparison
$today = now()->startOfDay();
$yesterday = now()->subDay()->startOfDay();
$thisMonth = now()->startOfMonth();
$lastMonth = now()->subMonth()->startOfMonth();

// Categorize sales based on order dates
foreach ($allSales as $sale) {
    $orderDate = Carbon::parse($sale['order_date']);
    if ($orderDate >= $today) {
        $todaySales[] = $sale;
        $todayTotalSalePrice += $sale['quantity'];
    }
    if ($orderDate >= $yesterday && $orderDate < $today) {
        $yesterdaySales[] = $sale;
        $yesterdayTotalSalePrice += $sale['quantity'];
    }
    if ($orderDate >= $thisMonth) {
        $thisMonthSales[] = $sale;
        $thisMonthTotalSalePrice += $sale['quantity'];
    }
    if ($orderDate >= $lastMonth && $orderDate < $thisMonth) {
        $lastMonthSales[] = $sale;
        $lastMonthTotalSalePrice += $sale['quantity'];
    }
}

    return view('dashboard', [
        'todaySales' => $todaySales,
        'yesterdaySales' => $yesterdaySales,
        'thisMonthSales' => $thisMonthSales,
        'lastMonthSales' => $lastMonthSales,
        'todayTotalSalePrice' => $todayTotalSalePrice,
        'yesterdayTotalSalePrice' => $yesterdayTotalSalePrice,
        'thisMonthTotalSalePrice' => $thisMonthTotalSalePrice,
        'lastMonthTotalSalePrice' => $lastMonthTotalSalePrice,
    ]);
        } elseif ($usertype == 'admin') {
            $salesData = DB::table('sales')
                ->select('selling_price', 'order_date')
                ->orderBy('order_date')
                ->get();

            $graphData = [];
            foreach ($salesData as $sale) {
                $day = Carbon::parse($sale->order_date)->format('Y-m-d');
                $graphData[$day][] = $sale->selling_price;
            }

            $averageData = [];
            foreach ($graphData as $day => $prices) {
                $averageData[$day] = round(array_sum($prices) / count($prices), 2);
            }

            $salesData = DB::table('sales')
                ->select(DB::raw('DATE(order_date) as date'), DB::raw('SUM(selling_price) as total_sales'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $dates = $salesData->pluck('date');
            $salesTotals = $salesData->pluck('total_sales');

            return view('admin.adminhome', compact('averageData', 'dates', 'salesTotals'));
        } else {
            // Handle other cases (e.g., unknown usertype)
            return redirect()->back();
        }
    } else {
        // User is not authenticated
        return redirect()->route('login');
    }
}

    
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // Update user data based on form input
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('home')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('home')->with('success', 'User deleted successfully');
    }
    public function create()
    {
        return view('admin.create_user');
    }

}
