<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use App\Models\Sales;
use App\Models\Woos;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
 
public function userPage($userId)
{
    $user = Auth::user();
$user_id = $user->id;
$apiKey = User::where('id', $userId)->value('api_key');
if (empty($apiKey)) {
    return view('user.not-found');
}
$page = 1;
$pageSize = 2000;
$allSales = [];
do {
    $apiUrl = "https://seller-api.takealot.com/v2/sales?page_number={$page}&page_size={$pageSize}";
    $response = Http::withHeaders([
        'Authorization' => $apiKey,
    ])->get($apiUrl);
    if ($response->successful()) {
        $data = $response->json();
         $tableName = "user_{$userId}_sales";

        foreach ($data['sales'] as $sale) {
            $existingRecord = DB::table($tableName)
                ->where('order_item_id', $sale['order_item_id'])
                ->first();

            if (!$existingRecord) {
                DB::table($tableName)->insert([
                    'order_item_id' => $sale['order_item_id'],
                    'order_id' => $sale['order_id'],
                    'order_date' => $sale['order_date'],
                    'sale_status' => $sale['sale_status'],
                    'offer_id' => $sale['offer_id'],
                    'tsin' => $sale['tsin'],
                    'sku' => $sale['sku'],
                    'product_title' => $sale['product_title'],
                    'takealot_url_mobi' => $sale['takealot_url_mobi'],
                    'selling_price' => $sale['selling_price'],
                    'quantity' => $sale['quantity'],
                    'dc' => $sale['dc'],
                    'customer' => $sale['customer'],
                    'takealot_url' => $sale['takealot_url'],
                    'success_fee' => $sale['success_fee'],
                    'fulfillment_fee' => $sale['fulfillment_fee'],
                    'courier_collection_fee' => $sale['courier_collection_fee'],
                    'auto_ibt_fee' => $sale['auto_ibt_fee'],
                    'total_fee' => $sale['total_fee'],
                ]);
            }
        }
        
        
        
        
        $pageSales = $data['sales'];
        $allSales = array_merge($allSales, $pageSales);
        $page++;
    } else {
        break;
    }
} while (!empty($pageSales));
$todaySales = [];
$yesterdaySales = [];
$thisMonthSales = [];
$lastMonthSales = [];

$todayTotalSalePrice = 0;
$yesterdayTotalSalePrice = 0;
$thisMonthTotalSalePrice = 0;
$lastMonthTotalSalePrice = 0;
$today = now()->startOfDay();
$yesterday = now()->subDay()->startOfDay();
$thisMonth = now()->startOfMonth();
$lastMonth = now()->subMonth()->startOfMonth();
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
   $tableName = "user_{$userId}_sales";
    $salesData = DB::table($tableName)->paginate(100000000000);

    return view('admin.menu', [
        'user' => $user,
        'salesData' => $salesData,
        'todaySales' => $todaySales,
        'yesterdaySales' => $yesterdaySales,
        'thisMonthSales' => $thisMonthSales,
        'lastMonthSales' => $lastMonthSales,
        'todayTotalSalePrice' => $todayTotalSalePrice,
        'yesterdayTotalSalePrice' => $yesterdayTotalSalePrice,
        'thisMonthTotalSalePrice' => $thisMonthTotalSalePrice,
        'lastMonthTotalSalePrice' => $lastMonthTotalSalePrice,
        'userId' => $userId,
    ]);
}



public function userProduct($userId)
{
    $user = Auth::user();
    $user_id = $user->id;
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $apiKey = $user->api_key;

    // Initialize the variables before the HTTP request
    $totalProductCount = 0;
    $buyableCount = 0;

    // Initialize an array to store all Takealot product data
    $takealotData = [];

    // Set the initial page number
    $page = 1;

    do {
        $apiUrl = "https://seller-api.takealot.com/v2/offers?page_number={$page}&page_size=2000";

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get($apiUrl);

        if ($response->successful()) {
            $pageData = $response->json()['offers'];
            $totalProductCount += count($pageData);
            $disable = collect($takealotData)->filter(function ($product) {
            return $product['status'] === 'Disabled by Seller';
        })->count();
        $buyableCount = collect($takealotData)->filter(function ($product) {
            return $product['status'] === 'Buyable';
        })->count();
        $notBuyableCount = collect($takealotData)->filter(function ($product) {
            return $product['status'] === 'Not Buyable';
        })->count();

            $takealotData = array_merge($takealotData, $pageData);
            $page++;
        } else {
            $takealotData = [];
            $disable = 0;
            $notBuyableCount = 0;
        }
    } while (!empty($pageData));

    $perPage = 1000000;
    $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
    $currentItems = array_slice($takealotData, ($currentPage - 1) * $perPage, $perPage);
    $takealotData = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, count($takealotData), $perPage, $currentPage);

    return view('admin.takelot-product', [
        'user' => $user,
        'takealotData' => $takealotData,
        'totalProductCount' => $totalProductCount,
        'buyableCount' => $buyableCount,
        'notBuyableCount' => $notBuyableCount,
        'disable' => $disable,
    ]);
}

public function userSaleinsert($userId)
{
    $user = Auth::user();
    $user_id = $user->id;
    $targetUser = User::find($userId);

    if (!$targetUser) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $apiKey = $targetUser->api_key;
    $apiUrl = 'https://seller-api.takealot.com/1/sales';

    $response = Http::withHeaders([
        'Authorization' => $apiKey,
    ])->get($apiUrl);

  if ($response->successful()) {
        $data = $response->json();

        $tableName = "user_{$userId}_sales";

        foreach ($data['sales'] as $sale) {
            $existingRecord = DB::table($tableName)
                ->where('order_item_id', $sale['order_item_id'])
                ->first();

            if (!$existingRecord) {
                DB::table($tableName)->insert([
                    'order_item_id' => $sale['order_item_id'],
                    'order_id' => $sale['order_id'],
                    'order_date' => $sale['order_date'],
                    'sale_status' => $sale['sale_status'],
                    'offer_id' => $sale['offer_id'],
                    'tsin' => $sale['tsin'],
                    'sku' => $sale['sku'],
                    'product_title' => $sale['product_title'],
                    'takealot_url_mobi' => $sale['takealot_url_mobi'],
                    'selling_price' => $sale['selling_price'],
                    'quantity' => $sale['quantity'],
                    'dc' => $sale['dc'],
                    'customer' => $sale['customer'],
                    'takealot_url' => $sale['takealot_url'],
                    'success_fee' => $sale['success_fee'],
                    'fulfillment_fee' => $sale['fulfillment_fee'],
                    'courier_collection_fee' => $sale['courier_collection_fee'],
                    'auto_ibt_fee' => $sale['auto_ibt_fee'],
                    'total_fee' => $sale['total_fee'],
                ]);
            }
        }
    }
   

   return back()->withInput();
}



 public function woo_pos()
    {
        $response = Http::get('https://woo-pos.com/index.php/api/get-data');
        $products = $response->json();

       return view('user.woo-pos', compact('products'));



    }
    
    public function minimum(){
        $salesData = Woos::paginate(10000000000);
         return view('admin.minimum',compact('salesData'));
    }
    public function minimum1(){
         $salesData = Woos::paginate(10000000);
         return view('user.minimum',compact('salesData'));
    }


}
