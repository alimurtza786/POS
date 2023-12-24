@extends('layouts.sidebar')
@section('content')

<style>
    svg {
    height: 25px;
    overflow: hidden;
    vertical-align: middle;
}
</style>
<section class="container">

        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    In Stock Item</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">100</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Out Stock Item</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">100</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Item On Rack
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">100</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Item Not On Rack</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">100</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>
 <section class="container" style="background: white;">

        <div class="table-responsive mb-5">
             <table id="dataTable" class="display" style="width:100%">
                <!--<div class="form-group">-->
                <!--    <label for="statusFilter" style="color: black">Filter Product:</label>-->
                <!--    <select id="statusFilter" class="form-control">-->
                <!--        <option value="">All</option>-->
                <!--        <option value="Buyable">Buyable</option>-->
                <!--        <option value="Not Buyable">Not buyable</option>-->
                <!--        <option value="Disabled by Seller">Disabled by Seller</option>-->
                <!--        <option value="Preparing for Customer">Preparing for Customer</option>-->
                <!--        <option value="Shipped to Customer">Shipped to Customer</option>-->
                <!--        <option value="Shipped Shipment">Shipped Shipment</option>-->
                <!--        <option value="Disabled by Seller">Disabled by Seller</option>-->
                <!--        <option value="Preparing for Customer">Preparing for Customer</option>-->
                <!--    </select>-->
                <!--</div>-->
            <div class="row pt-4">
                
                <div class="col-md-6 float-right">
                    <div class="heading float-right" >
                        <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>
                        <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>
                       </div>
                    </div>
                </div>
                <thead>
                  
                    <tr>
                        <th>Product Name</th>
                        <th>Barcode</th>
                        <th>Cost</th>
                        <th>Minimum Price</th>
                        <th>Rack No</th>
                    </tr>
                    
                </thead>
                <tbody>
    @foreach ($salesData as $salesKey)
        <tr>
            </td>
            <td>{{ $salesKey->name }} <a href="{{ $salesKey->slug }}" target="_blank"><span class="badge badge-warning"><i class="fa fa-globe"></i></span></a></td>
            <td>{{ $salesKey->code }}</td>
            <td>{{ number_format($salesKey->cost, 2) }}</td>
            <td>
                <?php
    // Assuming $salesKey->product_id contains the product ID for the current record
    $productId = $salesKey->id;

    // Fetch the cost for the specific product from the 'woos' table
    $woos = DB::table('woos')->where('id', $productId)->first();

    if ($woos) {
        $costPrice = $woos->price;

        $commission = 0;

        if ($costPrice <= 10) {
            $commission = 17;
        } elseif ($costPrice <= 40) {
            $commission = 18; 
        } elseif ($costPrice <= 80) {
            $commission = 19; 
        } else {
            $commission = 20; 
        }

         $commissionAmount = ($costPrice + 50) / 100 * $commission;
         $totalCost = ($costPrice + 50) + $commissionAmount;
       echo number_format($totalCost, 2) . " R";
    } else {
        echo "Product not found";
    }
    ?>
</td>
            <td>{{ $salesKey->rack }}</td>
        </tr>
    @endforeach
</tbody>

            </table>
            
        </div>
    </section>
     <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    @endsection