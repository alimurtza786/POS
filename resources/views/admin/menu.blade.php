@extends('layouts.sidebar')
@section('content')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get a reference to the button element
        const button = document.querySelector("#btn-primary");

        // Add a click event listener to the button
        button.addEventListener("click", function() {
            // Reload the current page when the button is clicked
            location.reload();
        });
    });
</script>

<section class="container">

    <div class="row">

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                   
                                                    Today Sale
                                               </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> @if (!empty($todayTotalSalePrice)){{ $todayTotalSalePrice }} @endif</div>
                                               
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
                                                    
                                                    Yesterday Sale
                                               </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">@if (!empty($yesterdayTotalSalePrice)){{ $yesterdayTotalSalePrice }} @endif</div>
                                               
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
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                   This Month Sale

                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">@if (!empty($thisMonthTotalSalePrice)){{ $thisMonthTotalSalePrice }} @endif</div>
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

                                                 Last Month Sale
                                               </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">  @if (!empty($lastMonthTotalSalePrice)) {{ $lastMonthTotalSalePrice }} @endif</div>
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
                        <section class="container">
   
 <!--<div class="heading" style="margin-top:10px;">-->
 <!--           <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>-->
 <!--            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary">SYC</button>-->
 <!--       </div>-->
        
   <div class="table-responsive">
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
    <div class="col-md-6">
        <div class="form-group">
            <label for="statusFilter" style="color: black">Filter Product:</label>
            <select id="statusFilter" class="form-control">
                <option value="">All</option>
                <option value="Buyable">Buyable</option>
                <option value="Not Buyable">Not buyable</option>
                <option value="Disabled by Seller">Disabled by Seller</option>
                <option value="Preparing for Customer">Preparing for Customer</option>
                <option value="Shipped to Customer">Shipped to Customer</option>
                <option value="Shipped Shipment">Shipped Shipment</option>
                <option value="Disabled by Seller">Disabled by Seller</option>
                <option value="Preparing for Customer">Preparing for Customer</option>
            </select>
        </div>
    </div>
    <div class="col-md-6 float-right">
        <div class="heading float-right" >
            <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>
            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary">SYC</button>
       
           </div>
        </div>

                <thead>
                    <tr>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>TSIN</th>
                        <th>SKU</th>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Selling Price</th>
                        <th>Selling Qty</th>
                        <th>DC</th>
                        <th>Customer Name</th>
                        <th>Total Fees</th>
                        <th>Top Sale</th>
                        <th>Top Return</th>
                        <th>POS Barcode</th>
                        <th>MY Soh (QTY)</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                  
                            @foreach ($salesData as $salesKey)
                                <tr>
                                   <td>
    @php
    $tableName = "user_{$userId}_posts";
        $product = DB::table($tableName)->where('offer_id', $salesKey->offer_id)->first();
    @endphp

    @if($product)
        <img src="{{ $product->image_url }}" width="80px">
    @else
        <img src="https://designs.hssolsdemos.com/no_image.png" width="80px">
    @endif
</td>

                                    <td> {{ $salesKey->product_title }} <a href="{{ $salesKey->takealot_url }}" target="_blank"><span class="badge badge-warning"><i class="fa fa-globe"></i></span></a></td>
                                    <td>{{ $salesKey->tsin }}</td>
                                    <td>{{ $salesKey->sku }}</td>
                                    <td>{{ $salesKey->order_id }}</td>
                                    <td>{{ $salesKey->order_date }}</td>
                                    <td>{{ $salesKey->sale_status }}</td>
                                    <td>{{ $salesKey->selling_price }}</td>
                                    <td>{{ $salesKey->quantity }}</td>
                                    <td>{{ $salesKey->dc }}</td>
                                    <td>{{ $salesKey->customer }}</td>
                                    <td>{{ $salesKey->total_fee }}</td>
  <td>
                @if ($salesKey->sale_status === 'Shipped to Customer')
                    <!-- Calculate and display the value for Shipped to Customer -->
                    <?php
                    $createdDate = \Carbon\Carbon::parse($salesKey->order_date);
                    $currentDate = \Carbon\Carbon::now();
                    $daysDifference = $createdDate->diffInDays($currentDate);
                    $value = $daysDifference + $salesKey->quantity; // Adjust the calculation as needed
                    ?>
                    {{ $value }}
                @else
                    0
                @endif
            </td>
            <td>
                @if ($salesKey->sale_status === 'Returned')
                    <!-- Calculate and display the value for Returned -->
                    <?php
                    $createdDate = \Carbon\Carbon::parse($salesKey->order_date);
                    $currentDate = \Carbon\Carbon::now();
                    $daysDifference = $createdDate->diffInDays($currentDate);
                    $value = $daysDifference + $salesKey->quantity; // Adjust the calculation as needed
                    ?>
                    {{ $value }}
                @else
                    0
                @endif
            </td>
            <td>No barcode match</td>
                                    <td>{{ $salesKey->quantity }}</td>
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
    <script>
         $(document).ready(function () {
        $('#statusFilter').change(function () {
            var selectedStatus = $(this).val();

            // Hide all rows initially
            $('#dataTable tbody tr').show();
            if (selectedStatus === '') {
                $('#dataTable tbody tr').show();
            } else {
                $('#dataTable tbody tr').each(function () {
                    var status = $(this).find('td:last').text();
                    if (status === selectedStatus) {
                        $(this).show();
                    }
                });
            }
        });
    });
        document.addEventListener('DOMContentLoaded', function () {
        const statusFilter = document.getElementById('statusFilter');
        const table = $('#dataTable').DataTable();

        statusFilter.addEventListener('change', function () {
            const selectedStatus = statusFilter.value;

            if (selectedStatus === '') {
                table.search('').draw();
            } else {
                table.search(selectedStatus).draw();
            }
        });
    });
    </script>
      <script>
        const headRow = [...document.querySelectorAll('table thead tr td')]
            .map(column => column.textContent.trim());

        const rows = [...document.querySelectorAll('table tbody tr')]
            .map(tr => [...tr.querySelectorAll('td')]
                .map(td => td.textContent.trim())
            );

        const content = [headRow, ...rows]
            .map(row => row.map(str => '"' + (str ? str.replace(/"/g, '""') : '') + '"'))
            .map(row => row.join(','))
            .join('\n');

        const BOM = '\uFEFF';
        const csvBlob = new Blob([BOM + content], {
            type: 'text/csv;charset=utf-8'
        });

        function showCsv() {
            console.log(content);
        }

        function download() {
            if (window.navigator.msSaveOrOpenBlob) {
                navigator.msSaveBlob(csvBlob, 'exampleTable.csv');
            } else {
                const objectUrl = URL.createObjectURL(csvBlob);
                const a = document.createElement('a');
                a.setAttribute('href', objectUrl);
                a.setAttribute('download', 'exampleTable.csv');

                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        }
    </script>
@endsection
