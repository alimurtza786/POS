@extends('layouts.user')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="container">

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
                    </section>
<section class="container" style="background: white;">


 <div class="heading" style="margin-top:10px;">
            <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>
        </div>
         <div class="table-responsive mb-5">
   <table id="dataTable" class="display" style="margin-top:20px; width:100%">
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

    <thead>
        <tr>
             <th>Image</th>
             <th>Title</th>
             <th>TSIN</th>
             <th>SKU</th>
            <th>MySOh (QTY)</th>
            <th>Price</th>
            <th>RRP</th>
             <th>Status</th>
             <th>Barcode</th>
            <th>Sold In last 60 Days</th>
            <th>Return In last 60 Days</th>
            <th>Profit & Loss</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($userPostsData as $salesKey)
    <tr>
        <td>
            <div class="text-wrap width-170 media">
                <div class="avatar me-2">
                    <a href="{{ $salesKey->offer_url }}" target="new">
                        <img style="height:50px;width:60px;" alt="{{ $salesKey->title }}" professional="" pet="" clipper="" src="{{ $salesKey->image_url }}" class="rounded-circle">
                    </a>
                </div>
            </div>
        </td>
        <td>{{ $salesKey->title }}</td>
        <td>{{ $salesKey->offer_id }}</td>
        <td>{{ $salesKey->sku }}</td>
        <td>{{ $salesKey->stock_at_takealot_total }}</td>
        <td>{{ $salesKey->selling_price }}</td>
        <td>{{ $salesKey->rrp }}</td>
        <td>
            <button class="btn btn-success btn-sm" style="color:white;background-color:
            <?php
            $status = $salesKey->status;
            if ($status == 'Disabled by Seller') {
                echo 'red';
            } elseif ($status == 'Not Buyable') {
                echo '#E2A03F';
            } elseif ($status == 'Buyable') {
                echo 'green';
            }
            ?>"> {{ $status }}</button>
        </td>
        <td>
           <button class="btn btn-sm btn-primary update-barcode" data-product-id="{{ $salesKey->id }}" data-toggle="modal" data-target="#updateBarcodeModal">Update</button>
    <div class="profit-loss-container" data-product-id="{{ $salesKey->id }}"></div>
        </td>
        <td>
            @if ($salesKey->status === 'Buyable')
                <!-- Calculate and display the value -->
                <?php
                $createdDate = \Carbon\Carbon::parse($salesKey->date_created);
                $currentDate = \Carbon\Carbon::now();
                $daysDifference = $createdDate->diffInDays($currentDate);
                $value = $daysDifference + $salesKey->selling_price; // Adjust the calculation as needed
                ?>
                {{ $value }}
            @else
                0
            @endif
        </td>
        <td>
            @if ($salesKey->status === 'Return')
                <!-- Calculate and display the value -->
                <?php
                $createdDate = \Carbon\Carbon::parse($salesKey->date_created);
                $currentDate = \Carbon\Carbon::now();
                $daysDifference = $createdDate->diffInDays($currentDate);
                $value = $daysDifference + $salesKey->selling_price; // Adjust the calculation as needed
                ?>
                {{ $value }}
            @else
                0
            @endif
        </td>
<td>
    <?php
     $user = Auth::user();
    $user_id = $user->id;
    $userPostsTable = "user_{$user_id}_posts";
    if (!Schema::hasTable($userPostsTable)) {
        return view('user.not-found');
    }
          $product = DB::table($userPostsTable)->where('barcode', $salesKey->barcode)->first();
        $woos = DB::table('woos')->where('code', $salesKey->posbarcode)->first();
        if ($woos && $woos->code = $salesKey->posbarcode) {
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
    </tr>
@endforeach

    </tbody>
</table>
</div>


   
                </section>
               


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
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable(); 
    });
</script>
<script>
    $(document).ready(function() {
    $('.update-barcode').click(function() {
        var productId = $(this).data('product-id');
        $('#productId').val(productId);
        $('#resultContainer').hide(); // Hide the profit/loss container initially
    });

    $('#saveBarcodeButton').click(function() {
        var productId = $('#productId').val();
        var newBarcode = $('#newBarcode').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('update-barcode-user') }}",
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
                    alert('Failed to update barcode.').modal('hide');
                }
            },
            error: function() {
                alert('Error updating barcode.').modal('hide');
            }
        });
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
const csvBlob = new Blob([BOM + content], { type: 'text/csv;charset=utf-8' });

function showCsv(){
console.log(content);
}

function download(){
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
