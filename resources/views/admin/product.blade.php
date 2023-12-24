@extends('layouts.sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const button = document.querySelector(".btn-primary");
        button.addEventListener("click", function() {
            location.reload();
        });
    });
</script>


<style>
    #dataTable_length{
        margin-top:20px;
    }
    #dataTable_filter{
        margin-top:20px;
    }
    #dataTable_wrapper {
    padding: 20px;
}

#dataTable_filter input {
    width: 200px; /* Adjust search input width */
    margin-right: 10px;
}
 .top-alert {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
</style>

<section class="container">
<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="resultMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--@if ($product)-->
<!--    <p>Product Name: {{ $product->name }}</p>-->
<!--    <p>Original Selling Price: {{ $product->selling_price }}</p>-->
<!--    <p>New Selling Price: {{ $newSellingPrice }}</p>-->
<!--@else-->
<!--    <p>Product not found for the entered barcode.</p>-->
<!--    <p>New Selling Price: N/A</p>-->
<!--@endif-->


<div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Buyable Products</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $buyableCount }}</div>
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
                                              Not Buyable Products</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $notBuyableCount }}</div>
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Disabled Products
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $disable }}</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                                               Total Products</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProductCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 <!--<div class="heading" style="margin-top:10px;">-->
 <!--           <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>-->
 <!--            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>-->
 <!--       </div>-->
<div class="table-responsive mb-5">
      <table id="dataTable" class="display" style="margin-top: 20px; width: 100%">
     
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
            </select>
        </div>
    </div>
    <div class="col-md-6 float-right">
        <div class="heading float-right" >
            <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>
            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>
           </div>
        </div>

    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>TSIN</th>
            <th>SKU</th>
            <th>MySOh (QTY)</th>
            <th>Price</th>
            <th>RRP</th>
             <th>POS Barcode</th>
             <th>Sold In last 60 Days</th>
            <th>Return In last 60 Days</th>
            <th>Profit and Loss</th>
            <th>Status</th>
            <th>Update</th>
            
        </tr>
    </thead>
   <tbody>
    @foreach ($salesData as $sale)
        <tr>
            <td>
                <div class="text-wrap width-170 media">
                    <div class="avatar me-2">
                       
                            <img style="height:50px;width:60px;" alt="{{ $sale->title }}" professional="" pet="" clipper="" src="{{ $sale->image_url }}" class="rounded-circle">
                       
                    </div>
                </div>
            </td>
            <td>{{ $sale->title }} <a href="{{ $sale->offer_url }}" target="_blank"><span class="badge badge-warning"><i class="fa fa-globe" ></i></span></a></td>
            <td>{{ $sale->tsin_id }}</td>
            <td>{{ $sale->sku }}</td>
            <td>{{ $sale->stock_at_takealot_total }}</td>
            <td>{{ $sale->selling_price }}</td>
            <td>{{ $sale->rrp }}</td>
          
<td>{{ $sale->posbarcode }} 
 <button class="btn btn-sm btn-primary update-barcode" data-product-id="{{ $sale->id }}" data-toggle="modal" data-target="#updateBarcodeModal">Update</button>
</td>

            <td>
    <?php
    $offerId = $sale->offer_id;
    $last60DaysSoldQuantity = \App\Models\Sales::where('offer_id', $offerId)
        ->where('sale_status', 'Shipped to Customer')
        ->where('order_date', '>=', now()->subDays(60))
        ->sum('quantity');

    echo $last60DaysSoldQuantity;
    ?>
</td>

            <td>
    <?php
    $offerId = $sale->offer_id;
    $last60DaysSoldQuantity = \App\Models\Sales::where('offer_id', $offerId)
        ->where('sale_status', 'Return')
        ->where('order_date', '>=', now()->subDays(60))
        ->sum('quantity');

    echo $last60DaysSoldQuantity;
    ?>
</td>
 <td>
    <?php
          $product = DB::table('products')->where('barcode', $sale->barcode)->first();
        $woos = DB::table('woos')->where('code', $sale->posbarcode)->first();
        if ($woos && $woos->code = $sale->posbarcode) {
            $sellingPrice = $product->selling_price;
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
$profitLoss = $sellingPrice - $totalCost;

            $profitLossStatus = ($profitLoss < 0) ? 'Loss' : 'Profit';
            echo "$profitLossStatus - $profitLoss R";
        } else {
            echo 'N/A';
        }
    ?>
</td>

            <td>
                <button class="btn btn-sm" style="color: white; background-color:
                    @if ($sale->status == 'Disabled by Seller')
                        red
                    @elseif ($sale->status == 'Not Buyable')
                        #E2A03F
                    @elseif ($sale->status == 'Buyable')
                        green
                    @endif
                ">{{ $sale->status }}</button>
            </td>
            <td>
                <button style="color: #fff; background-color: #4e73df; border-color: #4e73df;" class="update-product-btn" data-product-id="{{ $sale->id }}">Update</button>
            </td>
        </tr>
    @endforeach
</tbody>

</table>
</div>

<!-- Modal to update barcode -->
<div class="modal fade" id="updateBarcodeModal" tabindex="-1" role="dialog" aria-labelledby="updateBarcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBarcodeModalLabel">Update Barcode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateBarcodeForm">
                    @csrf
                    <div class="form-group">
                        <label for="newBarcode">New Barcode:</label>
                        <input type="text" class="form-control" id="newBarcode" name="newBarcode">
                    </div>
                    <input type="hidden" id="productId" name="productId" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBarcodeButton">Save</button>
            </div>
        </div>
    </div>
</div>



   
    
    
                </section>
                <div class="modal" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="updateProductForm">
                        @csrf
                        <input type="hidden" id="productId">
                        <div class="form-group">
                            <label for="newSku">New SKU</label>
                            <input type="text" class="form-control" name="sku" id="newSku">
                        </div>
                        <div class="form-group">
                            <label for="newPrice">New Price</label>
                            <input type="text" class="form-control" name="selling_price" id="newPrice">
                        </div>
                        <div class="form-group">
                            <label for="newRrp">New RRP</label>
                            <input type="text" class="form-control" name="rrp" id="newRrp">
                        </div>
                        <button type="button" class="btn btn-primary" id="updateProductButton">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
<div class="modal fade" id="updateBarcodeModal" tabindex="-1" role="dialog" aria-labelledby="updateBarcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBarcodeModalLabel">Barcode Update Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="resultContainer" style="display: none;">
                    <p id="resultMessage"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
   $('.update-barcode').click(function() {
    var productId = $(this).data('product-id');
    console.log('productId:', productId); // Add this line to log productId
    $('#productId').val(productId);
    $('#resultContainer').hide();
});

    $('#saveBarcodeButton').click(function() {
        var productId = $('#productId').val();
        var newBarcode = $('#newBarcode').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('update-barcode') }}",
            data: {
                _token: "{{ csrf_token() }}",
                productId: productId,
                newBarcode: newBarcode
            },
            success: function(data) {
                console.log(data); // Add this line to inspect the response

                if (data.success) {
                      var productId = $('#productId').val();
        var priceDifference = data.priceDifference;
                    var updateButton = $('.update-barcode[data-product-id="' + productId + '"]');
                    updateButton.hide();

                    var priceDifference = data.priceDifference;
                    var resultContainer = $('#resultContainer');
                    var resultMessage = $('#resultMessage');

                    console.log(priceDifference); // Add this line to inspect the value


        if (priceDifference !== null) {
            // Update the profit/loss container for the specific product
            var resultContainer = $('.profit-loss-container[data-product-id="' + productId + '"]');
            resultContainer.text('Profit/Loss: $' + priceDifference);
        } else {
                        console.log('Price difference is null or invalid.');
                    }

                    $('#updateBarcodeModal').modal('hide');
                } else {
                     $('#updateBarcodeModal').modal('hide');
                }
            },
            error: function() {
                $('#updateBarcodeModal').modal('hide');
            }
        });
    });
});

</script>



<script>
    $(document).ready(function() {
        $('#calculateButton').click(function() {
            var barcode = $('#barcode').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('get-profit-loss') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    barcode: barcode
                },
                success: function(data) {
                    var priceDifference = data.priceDifference;
                    var resultContainer = $('#resultContainer');
                    var resultMessage = $('#resultMessage');
                    
                    if (priceDifference !== null) {
                        // Display the profit/loss value in the result container
                        resultMessage.html('Profit/Loss: $' + priceDifference);
                        resultContainer.show();
                    } else {
                        // Display an error message in the result container
                        resultMessage.html('Barcode does not match. Please try again.');
                        resultContainer.show();
                    }
                },
                error: function() {
                    alert('Error fetching data.');
                }
            });
        });
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
 <script>
   $(document).ready(function () {
    $('.update-product-btn').click(function () {
        let productId = $(this).data('product-id');
        $('#productId').val(productId);
        $('#newSku').val('');
        $('#newPrice').val('');
        $('#newRrp').val('');
        $('#updateModal').modal('show');
    });


    $('#updateProductButton').click(function () {
        let productId = $('#productId').val();
        let newSku = $('#newSku').val();
        let newPrice = $('#newPrice').val();
        let newRrp = $('#newRrp').val();

        $.ajax({
            type: 'PUT',
            url: '/products/' + productId,
            data: {
                sku: newSku,
                selling_price: newPrice,
                rrp: newRrp,
            },
             headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
            success: function (response) {

                $('#updateModal').modal('hide');

                console.log(response.message);
            },
            error: function (error) {
                console.error(error.responseJSON.message);
            }
        });
    });
});

</script>
<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
            var barcode = $('#barcode').val();
            
            $.post("{{ route('calculate-profit-loss') }}", { _token: "{{ csrf_token() }}", barcode: barcode }, function (data) {
                var resultModal = $('#resultModal');
                var resultMessage = $('#resultMessage');
                
                if (data.error) {
                    resultMessage.html(data.error);
                } else {
                    resultMessage.html("Profit/Loss: $" + data.result);
                }
                
                resultModal.modal('show');
            });
        });
    });
</script>
<script>
        document.getElementById("lookupButton").addEventListener("click", function (e) {
            e.preventDefault(); // Prevent form submission

            var barcode = document.querySelector("input[name='barcode']").value;

            // Check if barcode is empty or doesn't match
            if (barcode === "" || !barcode.match(/^your-regex-pattern-here$/)) {
                // Show the Bootstrap alert
                showTopAlert();
            } else {
                // Submit the form
                document.querySelector("form").submit();
            }
        });

        // Function to show the Bootstrap alert at the top
        function showTopAlert() {
            var alert = document.querySelector(".top-alert");
            alert.style.display = "block";

            // Automatically dismiss the alert after 3 seconds
            setTimeout(function () {
                alert.style.display = "none";
            }, 3000);
        }
    </script>
<script>
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

@endsection
