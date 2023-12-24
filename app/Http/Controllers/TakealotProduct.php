<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use DB;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
class TakealotProduct extends Controller
{
   public function getData(Request $request)
{
    $user = Auth::user();
$user_id = $user->id;
$apiKey = User::where('id', $user_id)->value('api_key');
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
    $user = Auth::user();
$user_id = $user->id;

$userSalesTable = "user_{$user_id}_sales";
if (!Schema::hasTable($userSalesTable)) {
    return view('user.not-found');
}
$salesData = DB::table($userSalesTable)->get();
    //  $salesData = Sales::all();

    return view('user.sales', [
        'data' => $data,
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

    public function getproduct(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $apiKey = User::where('id', $user_id)->value('api_key');
        if (empty($apiKey)) {
            return view('user.not-found');
        }

        $apiUrl = 'https://seller-api.takealot.com/v2/offers?page_number=1&page_size=2000';

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get($apiUrl);
        if ($response->successful()) {
            $data = $response->json();

            // dd($data);
             if ($response->successful()) {
        $takealotData = $response->json()['offers'];
        $totalProductCount = count($takealotData);
        $disable = collect($takealotData)->filter(function ($product) {
            return $product['status'] === 'Disabled by Seller';
        })->count();
        $buyableCount = collect($takealotData)->filter(function ($product) {
            return $product['status'] === 'Buyable';
        })->count();
        $notBuyableCount = collect($takealotData)->filter(function ($product) {
            return $product['status'] === 'Not Buyable';
        })->count();
    } else {
        $takealotData = [];
        $disable = 0; 
    }

 $user = Auth::user();
    $user_id = $user->id;

    $userPostsTable = "user_{$user_id}_posts";
    if (!Schema::hasTable($userPostsTable)) {
        return view('user.not-found');
    }
    $userPostsData = DB::table($userPostsTable)->get();



            return view('user.products', ['data' => $data,
             'userPostsData' => $userPostsData,
             'takealotData' => $takealotData,
        'totalProductCount' => $totalProductCount,
        'buyableCount' => $buyableCount,
        'notBuyableCount' => $notBuyableCount,
        'disable' => $disable,]);
        } else {
            return view('user.not-found');
        }
    }
    
    public function updateBarcode(Request $request)
    {
        $productId = $request->input('productId');
        $newBarcode = $request->input('newBarcode');

        try {
             $user = Auth::user();
    $user_id = $user->id;
            $userPostsTable = "user_{$user_id}_posts";
    if (!Schema::hasTable($userPostsTable)) {
        return view('user.not-found');
    }
// DB::table('woos')->where('id', $productId)->update(['code' => $newBarcode]);
            DB::table($userPostsTable)->where('id', $productId)->update(['posbarcode' => $newBarcode]);

            $product = DB::table($userPostsTable)->where('id', $productId)->first();
            $woos = DB::table('woos')->where('id', $productId)->first();

            $profitLoss = null;

            if ($product && $woos) {
                $sellingPrice = $product->selling_price;
                $costPrice = $woos->cost;
                $commission = 0;
                if ($costPrice <= 10) {
                    $commission = 0.17; // 17%
                } elseif ($costPrice <= 40) {
                    $commission = 0.18; // 18%
                } elseif ($costPrice <= 80) {
                    $commission = 0.19; // 19%
                } else {
                    $commission = 0.20; // 20%
                }

                $commissionAmount = $costPrice * $commission;
                $totalCost = $costPrice + $commissionAmount + 50;
                $newProfitLoss = $sellingPrice - $totalCost;
                $profitLossStatus = ($newProfitLoss < 0) ? 'Loss' : 'Profit';
                echo "$profitLossStatus - $newProfitLoss R";
            } else {
                echo 'N/A';
            }

            return response()->json(['success' => true, 'priceDifference' => $priceDifference]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    
    
    
    
  public function product(Request $request)
{
    $apiKey = 'Key 6292c7b585822985bda83950e3d7f1637bed1a68efce8ed610d81d13af6483a1b2aa30e5cd280cafe52b6d477dda932d6971fabaf3c00a07acd59608e49d7883';
    $apiUrl = 'https://seller-api.takealot.com/v2/offers?page_number=1&page_size=2000';
    $response = Http::withHeaders([
        'Authorization' => $apiKey,
    ])->get($apiUrl);

    if ($response->successful()) {
        $data = $response->json();
        
return view('dashboard', ['data' => $data,]);
    } else {
        return response()->json(['error' => 'Failed to fetch data from Takealot API'], 500);
    }
}

    
    
    
    
    
    
    
    
}
