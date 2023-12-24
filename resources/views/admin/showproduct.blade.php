@extends('layouts.sidebar')
@section('content')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get a reference to the button element
        const button = document.querySelector(".btn-primary");

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
 <!--<div class="heading" style="margin-top:10px;">-->
 <!--           <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>-->
 <!--           <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>-->
 <!--       </div>-->
  <div class="mb-5 table-responsive mt-5">
       <table id="dataTable" class="display" style="width:100%">
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
            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>
           </div>
        </div>
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

       <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>TSIN</th>
            <th>SKU</th>
            <th>MySOh (QTY)</th>
            <th>Price</th>
            <th>RRP</th>
              <th>BarCode</th>
            <th>Sold In last 60 Days</th>
            <th>Return In last 60 Days</th>
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
             <td>{{ $sale->barcode }}</td>
              @if ($sale->status === 'Buyable')
                    <td>
                        <!-- Calculate and display the value -->
                        <?php
                        $createdDate = \Carbon\Carbon::parse($sale->date_created);
                        $currentDate = \Carbon\Carbon::now();
                        $daysDifference = $createdDate->diffInDays($currentDate);
                        $value = $daysDifference + $sale->stock_at_takealot_total;
                        ?>
                        {{ $value }}
                    </td>
                @else
                    <td>0</td> 
                @endif
            @if ($sale->status === 'Returned')
                    <td>
                        <!-- Calculate and display the value -->
                        <?php
                        $createdDate = \Carbon\Carbon::parse($sale->date_created);
                        $currentDate = \Carbon\Carbon::now();
                        $daysDifference = $createdDate->diffInDays($currentDate);
                        $value = $daysDifference + $sale->stock_at_takealot_total;
                        ?>
                        {{ $value }}
                    </td>
                @else
                    <td>0</td> 
                @endif

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
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });

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
    document.addEventListener("DOMContentLoaded", function () {
        const statusFilter = document.getElementById("statusFilter");
        const dataTable = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
        const rows = dataTable.getElementsByTagName("tr");

        statusFilter.addEventListener("change", function () {
            const selectedStatus = statusFilter.value;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const statusCell = row.cells[6]; // Adjust the index as needed

                if (selectedStatus === "" || statusCell.innerText === selectedStatus) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
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
