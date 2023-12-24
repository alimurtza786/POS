@extends('layouts.sidebar')
@section('content')



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

<section class="container" style=" background-color:white;margin-top:20px;">
<h3>User: {{ $user->name }}</h3>
 <div class="heading" style="margin-top:10px;">
            <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>
            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>
        </div>


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
<table id="dataTable" class="display" style="width:100%">
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
       </tr>
        </thead>
      <tbody>
    @if (!empty($takealotData))
        @foreach ($takealotData as $salesKey)
            <tr>
                <td>
                    <div class="text-wrap width-170 media">
                        <div class="avatar me-2">
                            <a href="{{ $salesKey['offer_url'] }}" target="_new">
                                <img style="height:50px;width:60px;" alt="{{ $salesKey['title'] }}" professional="" pet="" clipper="" src="{{ $salesKey['image_url'] }}" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </td>
                <td><a href="{{ $salesKey['offer_url'] }}" target="_blank">{{ $salesKey['title'] }}</a></td>
                <td>{{ $salesKey['tsin_id'] }}</td>
                <td>{{ $salesKey['sku'] }}</td>
                <td>{{ $salesKey['stock_at_takealot_total'] }}</td>
                <td>{{ $salesKey['selling_price'] }}</td>
                <td>{{ $salesKey['rrp'] }}</td>
                <td>{{ $salesKey['barcode'] }}</td>
                <td>
                    <button class="btn btn-success btn-sm" style="color:white;background-color:
                    @php
                    $status = $salesKey['status'];
                    if ($status == 'Disabled by Seller') {
                        echo 'red';
                    } elseif ($status == 'Not Buyable') {
                        echo '#E2A03F';
                    } elseif ($status == 'Buyable') {
                        echo 'green';
                    }
                    @endphp
                    ">{{ $salesKey['status'] }}</button>
                </td>
                <td>
                    @if ($salesKey['status'] === 'Buyable' || $salesKey['status'] === 'Returned')
                        @php
                        $createdDate = \Carbon\Carbon::parse($salesKey['date_created']);
                        $currentDate = \Carbon\Carbon::now();
                        $daysDifference = $createdDate->diffInDays($currentDate);
                        $value = $daysDifference + $salesKey['stock_at_takealot_total']; // Adjust the calculation as needed
                        @endphp
                        {{ $value }}
                    @else
                        
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        
    @endif
</tbody>

    </table>
   
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
