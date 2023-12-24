<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use App\Models\Woos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TakealotApiController extends Controller
{
    public function getData(Request $request)
    {
        $query = Sales::query();
        $apiKey = 'Key 6292c7b585822985bda83950e3d7f1637bed1a68efce8ed610d81d13af6483a1b2aa30e5cd280cafe52b6d477dda932d6971fabaf3c00a07acd59608e49d7883';
        $apiUrl = 'https://seller-api.takealot.com/1/sales?page_number=2&page_size=1000';

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get($apiUrl);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            if ($response->successful()) {
                $data = $response->json();
            }
            foreach ($data['sales'] as $sale) {
                // Check if the record already exists in the database
                $existingRecord = Sales::where('order_item_id', $sale['order_item_id'])->first();

                if (!$existingRecord) {
                    Sales::create([
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
$searchText = $request->input('searchText');
    $filter = $request->input('statusFilter');

    $query = Sales::query();

    if (!empty($filter)) {
        $salesData = $query->where('sale_status', $filter)->paginate(1000000000);
    } elseif ($searchText) {
        $salesData = $query->where(function ($q) use ($searchText) {
            $q->where('product_title', 'like', '%' . $searchText . '%')
                ->orWhere('customer', 'like', '%' . $searchText . '%');
        })->paginate(1000000000);
    } else {
        $salesData = $query->paginate(1000000000);
    }
            
            $timezone = config('app.timezone');
            $now = Carbon::now($timezone);
            $now = Carbon::now($timezone);
            $today = $now->copy()->startOfDay();
            $yesterday = $now->copy()->subDay()->startOfDay();
            $startOfThisMonth = $now->copy()->startOfMonth();
            $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
            function getTotalSales($query, $start, $end)
            {
                return $query->where('order_date', '>=', $start->format('Y-m-d H:i:s'))
                    ->where('order_date', '<', $end->format('Y-m-d H:i:s'))
                    ->sum('selling_price');
            }
            function getInitialStatus($query, $date)
            {
                return $query->where('order_date', '>=', $date->format('Y-m-d H:i:s'))
                    ->orderBy('order_date')
                    ->value('sale_status');
            }
            $todayStatus = getInitialStatus($query, $today);
            $yesterdayStatus = getInitialStatus($query, $yesterday);
            $todaySales = ($todayStatus === 'Shipped to Customer') ? getTotalSales($query, $today, $now) : 0;
            $yesterdaySales = ($yesterdayStatus === 'Shipped to Customer') ? getTotalSales($query, $yesterday, $today) : 0;
            $thisMonthSales = getTotalSales($query, $startOfThisMonth, $now);
            $lastMonthSales = getTotalSales($query, $startOfLastMonth, $startOfThisMonth);

            $totalProductCount = Product::count();

            return view('admin.sales', [
                'data' => $data,
                'salesData' => $salesData,
                'totalProductCount' => $totalProductCount,
                'todaySales' => $todaySales,
                'yesterdaySales' => $yesterdaySales,
                'thisMonthSales' => $thisMonthSales,
                'lastMonthSales' => $lastMonthSales,
            ]);

        } else {
            return view('user.not-found');
        }
    }

    public function showSalesData()
    {
        $apiKey = 'Key 6292c7b585822985bda83950e3d7f1637bed1a68efce8ed610d81d13af6483a1b2aa30e5cd280cafe52b6d477dda932d6971fabaf3c00a07acd59608e49d7883';
        $apiUrl = 'https://seller-api.takealot.com/1/sales?page_number=1&page_size=1000';

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
        ])->get($apiUrl);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            $todaySales = [];
            $yesterdaySales = [];
            $thisMonthSales = [];
            $lastMonthSales = [];

            // Initialize total sale prices for each period
            $todayTotalSalePrice = 0;
            $yesterdayTotalSalePrice = 0;
            $thisMonthTotalSalePrice = 0;
            $lastMonthTotalSalePrice = 0;

            // Check if the request was successful
            if ($response->successful()) {
                $data = $response->json();
                $today = now()->startOfDay();
                $yesterday = now()->subDay()->startOfDay();
                $thisMonth = now()->startOfMonth();
                $lastMonth = now()->subMonth()->startOfMonth();

                foreach ($data['sales'] as $sale) {
                    $orderDate = Carbon::parse($sale['order_date']);

                    // Add sale to the appropriate period and calculate total price
                    if ($orderDate >= $today) {
                        $todaySales[] = $sale;
                        $todayTotalSalePrice += $sale['selling_price'];
                    }
                    if ($orderDate >= $yesterday && $orderDate < $today) {
                        $yesterdaySales[] = $sale;
                        $yesterdayTotalSalePrice += $sale['selling_price'];
                    }
                    if ($orderDate >= $thisMonth) {
                        $thisMonthSales[] = $sale;
                        $thisMonthTotalSalePrice += $sale['selling_price'];
                    }
                    if ($orderDate >= $lastMonth && $orderDate < $thisMonth) {
                        $lastMonthSales[] = $sale;
                        $lastMonthTotalSalePrice += $sale['selling_price'];
                    }
                }
            }
        }

        $salesData = Sales::all();

        return view('admin.salesdata', ['salesData' => $salesData,
            'data' => $data,
            'todaySales' => $todaySales,
            'yesterdaySales' => $yesterdaySales,
            'thisMonthSales' => $thisMonthSales,
            'lastMonthSales' => $lastMonthSales,
            'todayTotalSalePrice' => $todayTotalSalePrice,
            'yesterdayTotalSalePrice' => $yesterdayTotalSalePrice,
            'thisMonthTotalSalePrice' => $thisMonthTotalSalePrice,
            'lastMonthTotalSalePrice' => $lastMonthTotalSalePrice]);
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
            $totalProductCount = Product::count();
            $buyableCount = Product::where('status', 'Buyable')->count();
            $notBuyableCount = Product::where('status', 'Not buyable')->count();
            $disable = Product::where('status', 'Disabled by Seller')->count();
            foreach ($data['offers'] as $sale) {
                $existingRecord = Product::where('offer_id', $sale['offer_id'])->first();

                if (!$existingRecord) {
                    Product::create([
                        'status' => $sale['status'],
                        'offer_id' => $sale['offer_id'],
                        'tsin_id' => $sale['tsin_id'],
                        'barcode' => $sale['barcode'],
                        'sales_units' => $sale['sales_units'],
                        'stock_cover' => $sale['stock_cover'],
                        'stock_on_way' => $sale['stock_on_way'],
                        'stock_at_takealot' => $sale['stock_at_takealot'],
                        'sku' => $sale['sku'],
                        'product_label_number' => $sale['product_label_number'],
                        'selling_price' => $sale['selling_price'],
                        'rrp' => $sale['rrp'],
                        'leadtime_days' => $sale['leadtime_days'],
                        'leadtime_stock' => $sale['leadtime_stock'],
                        'title' => $sale['title'],
                        'offer_url' => $sale['offer_url'],
                        'image_url' => $sale['image_url'],
                        'stock_at_takealot' => $sale['stock_at_takealot'],
                        'stock_on_way' => $sale['stock_on_way'],
                        'total_stock_on_way' => $sale['total_stock_on_way'],
                        'stock_cover' => $sale['stock_cover'],
                        'total_stock_cover' => $sale['total_stock_cover'],
                        'sales_units' => $sale['sales_units'],
                        'stock_at_takealot_total' => $sale['stock_at_takealot_total'],
                        'date_created' => $sale['date_created'],
                        'storage_fee_eligible' => $sale['storage_fee_eligible'],
                        'discount' => $sale['discount'],
                        'discount_shown' => $sale['discount_shown'],
                        'replen_block_jhb' => $sale['replen_block_jhb'],
                        'replen_block_cpt' => $sale['replen_block_cpt'],
                    ]);
                }
            }
            
            $salesData = Product::paginate(1000000000);
            $barcode = $request->input('barcode');
            $response = Http::get('https://woo-pos.com/index.php/api/get-data', [
                'code' => $barcode,
            ]);
            $data = $response->json();

            $product = Product::where('barcode', $barcode)->first();

            if ($product) {
                $newSellingPrice = $product->selling_price - $data['selected_barcode_selling_price'];
                return view('admin.product', [
                    'product' => $product,
                    'newSellingPrice' => $newSellingPrice,
                    'salesData' => $salesData,
                    'totalProductCount' => $totalProductCount,
                    'data' => $data,
                    'buyableCount' => $buyableCount,
                    'notBuyableCount' => $notBuyableCount,
                    'disable' => $disable,
                ]);
            } else {

                return view('admin.product', [
                    'product' => null,
                    'salesData' => $salesData,
                    'totalProductCount' => $totalProductCount,
                    'data' => $data,
                    'buyableCount' => $buyableCount,
                    'notBuyableCount' => $notBuyableCount,
                    'disable' => $disable,
                ]);
            }
        } else {
            return view('user.not-found');
        }
    }

    public function showproduct()
    {

        $salesData = Product::all();
        $totalProductCount = Product::count();
        $buyableCount = Product::where('status', 'Buyable')->count();
        $notBuyableCount = Product::where('status', 'Not buyable')->count();
        $disable = Product::where('status', 'Disabled by Seller')->count();

        return view('admin.showproduct', ['salesData' => $salesData, 'totalProductCount' => $totalProductCount, 'buyableCount' => $buyableCount, 'notBuyableCount' => $notBuyableCount, 'disable' => $disable]);
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'sku' => 'required|string|max:255',
            'selling_price' => 'required|numeric',
            'rrp' => 'required|numeric',
        ]);

        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully']);
    }

    // WOO-POS API DATA

    public function woo_pos()
    {
        $response = Http::get('https://woo-pos.com/index.php/api/get-data');
        $products = Woos::paginate(100000000000000);

        return view('admin.woo-pos', compact('products'));
    }

    public function getWoos($id)
    {
        $product = Woos::find($id);
        return response()->json($product);
    }

    public function user_pos()
    {
        $response = Http::get('https://woo-pos.com/index.php/api/get-data');
        $products = Woos::all();

        return view('user.woo-pos', compact('products'));

    }

    public function getSellingPrices(Request $request)
    {
        $takealotBarcode = $request->input('takealotBarcode');
        $takealotResponse = Http::withHeaders([
            'Authorization' => 'Bearer Key 6292c7b585822985bda83950e3d7f1637bed1a68efce8ed610d81d13af6483a1b2aa30e5cd280cafe52b6d477dda932d6971fabaf3c00a07acd59608e49d7883',
        ])->get("https://seller-api.takealot.com/v2/offers?barcode=$takealotBarcode");
        if (!$takealotResponse->successful()) {
            return response()->json(['error' => 'Failed to get Takealot selling price']);
        }
        $takealotPrice = $takealotResponse->json();
        $wooposResponse = Http::post('https://woo-pos.com/index.php/api/get-data', [
            'barcode_symbology' => $takealotBarcode,
        ]);

        if (!$wooposResponse->successful()) {
            return response()->json(['error' => 'Failed to get WooPOS selling price']);
        }

        $wooposPrice = $wooposResponse->json();

        $profitLoss = $takealotPrice - $wooposPrice;

        return response()->json([
            'takealotPrice' => $takealotPrice,
            'wooposPrice' => $wooposPrice,
            'profitLoss' => $profitLoss,
        ]);
    }

    public function getProfitLossData(Request $request)
    {

    }

    public function updateBarcode(Request $request)
    {
        $productId = $request->input('productId');
        $newBarcode = $request->input('newBarcode');

        try {
// DB::table('woos')->where('id', $productId)->update(['code' => $newBarcode]);
            DB::table('products')->where('id', $productId)->update(['posbarcode' => $newBarcode]);

            $product = DB::table('products')->where('id', $productId)->first();
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
    public function updateBarcode1(Request $request)
    {
        $productId = $request->input('productId');
        $newBarcode = $request->input('newBarcode');
        $sellingPrice = $request->input('sellingPrice');
        $newRack = $request->input('newRack');
        $newStackHandler = $request->input('newStackHandler');

        try {
            // Update the 'products' table with the new barcode
            DB::table('products')->where('id', $productId)->update(['barcode' => $newBarcode]);

            // Update the 'woos' table with the new barcode, rack, and stack_handler
            DB::table('woos')->where('id', $productId)->update([
                'barcode' => $newBarcode,
                'rack' => $newRack,
                'price' => $sellingPrice,
                'stack_handler' => $newStackHandler,
            ]);

            // Get the offer_id from the 'products' table
            $product = DB::table('products')->where('id', $productId)->first();
            $offerId = $product->offer_id;

            // Check if there is a matching offer_id in the 'sales' database
            $matchingSale = DB::table('sales')->where('offer_id', $offerId)->first();

            if ($matchingSale) {
                // Update the 'barcode' column in the 'sales' table
                DB::table('sales')->where('offer_id', $offerId)->update(['barcode' => $newBarcode]);
            }

            $woos = DB::table('woos')->where('id', $productId)->first();

            $priceDifference = null;

            if ($product && $woos) {
                $sellingPrice = $product->selling_price;
                $costPrice = $woos->cost;
                $priceDifference = $sellingPrice - $costPrice;
            }

            return response()->json(['success' => true, 'priceDifference' => $priceDifference]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

     public function report1(Request $request)
{
    $user = Auth::user();
$user_id = $user->id;

$userSalesTable = "user_{$user_id}_sales";

$statuses = DB::table($userSalesTable)->distinct()->pluck('sale_status');
$dateRange = $request->input('date_range');
$startDate = $request->input('start_date');
$endDate = $request->input('end_date');
$status = $request->input('status');

// Initialize the query
$query = DB::table($userSalesTable);
    $query->when($dateRange, function ($query) use ($dateRange, $startDate, $endDate) {
        switch ($dateRange) {
            case 'today':
                $query->where('order_date', '=', \Carbon\Carbon::today()->format('d M Y'));
                break;
            case 'yesterday':
                $query->where('order_date', '=', \Carbon\Carbon::yesterday()->format('d M Y'));
                break;
            case 'thismonth':
                $query->where('order_date', '>=', \Carbon\Carbon::today()->subDays(29)->format('d M Y'));
                break;
            case 'lastmonth':
                $query->where('order_date', '>=', \Carbon\Carbon::today()->subDays(30)->format('d M Y'));
                break;
            case 'last7days':
                $query->where('order_date', '>=', \Carbon\Carbon::today()->subDays(6)->format('d M Y'));
                break;
            case 'last30days':
                $query->where('order_date', '>=', \Carbon\Carbon::today()->subDays(29)->format('d M Y'));
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('order_date', [
                        \Carbon\Carbon::parse($startDate)->format('d M Y'),
                        \Carbon\Carbon::parse($endDate)->format('d M Y')
                    ]);
                }
                break;
        }
    });

    // Apply sale status filter
    $query->when($status, function ($query) use ($status) {
        return $query->where('sale_status', $status);
    });

    // Paginate the results with a specified number per page
    $salesData = $query->paginate(1000000000);

    // Append the search parameters to the pagination links
    $salesData->appends([
        'date_range' => $dateRange,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'status' => $status,
    ]);

    // Pass the data to the view
    return view('user.report', [
        'salesData' => $salesData,
        'statuses' => $statuses,
        'request' => $request,
    ]);
}






private function setDatesBasedOnRange($dateRange, &$startDate, &$endDate)
{
    $today = now()->format('Y-m-d');
    $yesterday = now()->subDay()->format('Y-m-d');
    
    switch ($dateRange) {
        case 'today':
            $startDate = $today;
            $endDate = $today;
            break;
        case 'yesterday':
            $startDate = $yesterday;
            $endDate = $yesterday;
            break;
        case 'last7days':
            $startDate = now()->subDays(6)->format('Y-m-d');
            $endDate = $today;
            break;
        case 'last30days':
            $startDate = now()->subDays(29)->format('Y-m-d');
            $endDate = $today;
            break;
        case 'thismonth':
            $startDate = now()->firstOfMonth()->format('Y-m-d');
            $endDate = now()->lastOfMonth()->format('Y-m-d');
            break;
        case 'lastmonth':
            $startDate = now()->subMonthNoOverflow()->firstOfMonth()->format('Y-m-d');
            $endDate = now()->subMonthNoOverflow()->lastOfMonth()->format('Y-m-d');
            break;
    }
}

    public function updateOffer(Request $request, $offerId)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required',
            'barcode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed'], 400);
        }
        $apiKey = 'Key 6292c7b585822985bda83950e3d7f1637bed1a68efce8ed610d81d13af6483a1b2aa30e5cd280cafe52b6d477dda932d6971fabaf3c00a07acd59608e49d7883';
        $newSku = $request->input('sku');
        $newBarcode = $request->input('barcode');
        $takealotApiUrl = 'https://seller-api.takealot.com/v2/offers/offer/' . $offerId;
        $updateData = [
            'sku' => $newSku,
            'barcode' => $newBarcode,
        ];

        $headers = [
            'Authorization' => $apiKey,
            'Accept' => 'application/json',
        ];

        $client = new Client();
        try {
            $response = $client->put($takealotApiUrl, [
                'json' => $updateData,
                'headers' => $headers,
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

            if ($statusCode === 200) {
                return response()->json(['message' => 'Offer updated successfully']);
            } else {
                return response()->json(['error' => 'Update failed', 'response' => $responseData], $statusCode);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Update failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function importData()
    {
        $response = Http::get('https://woo-pos.com/index.php/api/get-data');
        if ($response->successful()) {
            $apiData = $response->json();
            foreach ($apiData as $data) {
                $existingProduct = Woos::where('code', $data['code'])->first();

                if (!$existingProduct) {
                    Woos::create([
                        'id' => $data['id'],
                        'code' => $data['code'],
                        'name' => $data['name'],
                        'unit' => $data['unit'],
                        'cost' => $data['cost'],
                        'price' => $data['price'],
                        'alert_quantity' => $data['alert_quantity'],
                        'image' => $data['image'],
                        'category_id' => $data['category_id'],
                        'subcategory_id' => $data['subcategory_id'],
                        'cf1' => $data['cf1'],
                        'cf2' => $data['cf2'],
                        'cf3' => $data['cf3'],
                        'cf4' => $data['cf4'],
                        'cf5' => $data['cf5'],
                        'cf6' => $data['cf6'],
                        'quantity' => $data['quantity'],
                        'tax_rate' => $data['tax_rate'],
                        'track_quantity' => $data['track_quantity'],
                        'details' => $data['details'],
                        'warehouse' => $data['warehouse'],
                        'barcode_symbology' => $data['barcode_symbology'],
                        'file' => $data['file'],
                        'product_details' => $data['product_details'],
                        'tax_method' => $data['tax_method'],
                        'type' => $data['type'],
                        'supplier1' => $data['supplier1'],
                        'supplier1price' => $data['supplier1price'],
                        'supplier2' => $data['supplier2'],
                        'supplier2price' => $data['supplier2price'],
                        'supplier3' => $data['supplier3'],
                        'supplier3price' => $data['supplier3price'],
                        'supplier4' => $data['supplier4'],
                        'supplier4price' => $data['supplier4price'],
                        'supplier5' => $data['supplier5'],
                        'supplier5price' => $data['supplier5price'],
                        'promotion' => $data['promotion'],
                        'promo_price' => $data['promo_price'],
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date'],
                        'supplier1_part_no' => $data['supplier1_part_no'],
                        'supplier2_part_no' => $data['supplier2_part_no'],
                        'supplier3_part_no' => $data['supplier3_part_no'],
                        'supplier4_part_no' => $data['supplier4_part_no'],
                        'supplier5_part_no' => $data['supplier5_part_no'],
                        'sale_unit' => $data['sale_unit'],
                        'purchase_unit' => $data['purchase_unit'],
                        'brand' => $data['brand'],
                        'slug' => $data['slug'],
                        'featured' => $data['featured'],
                        'weight' => $data['weight'],
                        'hsn_code' => $data['hsn_code'],
                        'views' => $data['views'],
                        'hide' => $data['hide'],
                        'second_name' => $data['second_name'],
                        'hide_pos' => $data['hide_pos'],
                    ]);
                }

            }
            return response()->json(['message' => 'Data imported successfully']);
        }
        return response()->json(['message' => 'Failed to fetch data from the API'], 500);
    }

}
