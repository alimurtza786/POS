<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sales;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserRole extends Controller
{
    public function index()
    {
        $users = User::all(); 

        return view('admin.user.index', compact('users'));
    }
    public function showRegistrationForm(){
        return view('admin.user.user-create');
    }
    protected function validator(Request $request)
    {
        return Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

protected function create(Request $request)
{
   $existingUser = User::where('email', $request->input('email'))->first();
    if ($existingUser) {
        return redirect()->back()->withInput()->withErrors(['email' => 'Email already exists.']);
    }
    $existingUserkey = User::where('api_key', $request->input('api_key'))->first();
    if ($existingUserkey) {
        return redirect()->back()->withInput()->withErrors(['api_key' => 'Api Key already exists.']);
    }
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'api_key' => $request->input('api_key'),
    ]);

    
    Schema::create("user_{$user->id}_posts", function (Blueprint $table) {
        $table->id();
        $table->string('status');
        $table->integer('offer_id');
        $table->string('tsin_id');
        $table->string('sku');
        $table->string('offer_url');
          $table->string('image_url');
        $table->string('title');
        $table->decimal('stock_at_takealot_total', 8, 2);
        $table->decimal('selling_price', 8, 2);
        $table->decimal('rrp', 8, 2);
        $table->timestamp('date_created');
        $table->string('barcode');
       $table->string('posbarcode')->nullable();
        $table->timestamps();
    });
Schema::create("user_{$user->id}_sales", function (Blueprint $table) {
        $table->id();
        $table->string('order_item_id');
        $table->string('order_id');
        $table->string('order_date');
        $table->string('sale_status');
        $table->string('offer_id');
        $table->string('tsin');
        $table->string('sku');
        $table->string('product_title');
        $table->string('takealot_url_mobi');
        $table->string('selling_price');
        $table->string('quantity');
        $table->string('dc');
        $table->string('customer');
        $table->string('takealot_url');
        $table->string('success_fee');
        $table->string('fulfillment_fee');
        $table->string('courier_collection_fee');
        $table->string('auto_ibt_fee');
        $table->string('total_fee');
        $table->string('posbarcode')->nullable();
        $table->timestamps();
    });

    $apiUrl = 'https://seller-api.takealot.com/v2/offers';
    $currentPage = 1;
    $pageSize = 2000;
    $dataToInsert = [];

    do {
        $response = Http::withHeaders([
            'Authorization' => $user->api_key,
        ])->get("{$apiUrl}?page_number={$currentPage}&page_size={$pageSize}");

        if (!$response->successful()) {
            return view('user.not-found');
        }

        foreach ($response->json()['offers'] as $sale) {
            if (is_array($sale)) {
                $dataToInsert[] = [
                    'status' => is_array($sale['status']) ? json_encode($sale['status']) : (string) $sale['status'] ?? '',
                    'offer_id' => (int) $sale['offer_id'] ?? 0,
                    'tsin_id' => (string) $sale['tsin_id'] ?? '',
                    'sku' => (string) $sale['sku'] ?? '',
                    'title' => (string) $sale['title'] ?? '',
                     'offer_url' => (string) $sale['offer_url'] ?? '',
                    'image_url' => (string) $sale['image_url'] ?? '',
                     'date_created' => (string) $sale['date_created'] ?? '',
                    'stock_at_takealot_total' => (float) $sale['stock_at_takealot_total'] ?? 0.0,
                    'selling_price' => (float) $sale['selling_price'] ?? 0.0,
                    'rrp' => (float) $sale['rrp'] ?? 0.0,
                    'barcode' => $sale['barcode'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $currentPage++;
    } while (!empty($response->json()['offers']));
    $userPostsTable = "user_{$user->id}_posts";
    $chunkSize = 2000; 
    $chunks = array_chunk($dataToInsert, $chunkSize);
    foreach ($chunks as $chunk) {
    DB::table($userPostsTable)->insert($chunk);
    }

     
   $apiSalesUrl = 'https://seller-api.takealot.com/v2/sales';
    $pageSize = 2000;
    $salesDataToInsert = [];

    $currentPage = 1;

    do {
        $response = Http::withHeaders([
            'Authorization' => $user->api_key,
        ])->get("{$apiSalesUrl}?page_number={$currentPage}&page_size={$pageSize}");

        if (!$response->successful()) {
            return view('user.not-found');
        }

        foreach ($response->json()['sales'] as $sale) {
            if (is_array($sale)) {
                $salesDataToInsert[] = [
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }

   $currentPage++;
    } while (!empty($response->json()['sales']));
    $userSalesTable = "user_{$user->id}_sales";
 $chunkSize = 2000; 
    $chunks = array_chunk($salesDataToInsert, $chunkSize);
    foreach ($chunks as $chunk) {
    DB::table($userSalesTable)->insert($chunk);
    }


    return redirect()->route('user-all');
}



public function updateUser(Request $request)
    {
        // Validate the request
        $request->validate([
            'userId' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->userId,
            'api_key' => 'nullable|string',
        ]);

        $user = User::find($request->userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->api_key = $request->api_key;
        $user->save();

        // Return a response, e.g., a success message
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteUser(Request $request)
    {
        // Validate the request
        $request->validate([
            'userId' => 'required|exists:users,id',
        ]);

        $user = User::find($request->userId);
        $user->delete();

        // Return a response, e.g., a success message
        return response()->json(['message' => 'User deleted successfully']);
    }
    
    
public function report(Request $request)
{
    // Fetch unique sale statuses
    $statuses = Sales::distinct()->pluck('sale_status');

    // Retrieve search parameters from the request
    $dateRange = $request->input('date_range');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $status = $request->input('status');

    // Initialize the query
    $query = Sales::query();

    // Apply date range filters
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
    $salesData = $query->paginate(10);

    // Append the search parameters to the pagination links
    $salesData->appends([
        'date_range' => $dateRange,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'status' => $status,
    ]);

    // Pass the data to the view
    return view('admin.report', [
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

}
