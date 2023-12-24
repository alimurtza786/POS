@extends('layouts.user')
@section('content')


 <section class="container" style="background: white;">
        <!--<div class="heading" style="margin-top:10px;">-->
        <!--    <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>-->
        <!--    <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>-->
        <!--</div>-->

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