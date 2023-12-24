@extends('layouts.sidebar')
@section('content')
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 10px;
            color: inherit;
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
                                                    @if (!empty($todayTotalSalePrice))
                                                    Today Sale
                                               </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayTotalSalePrice }}</div>
                                                @endif
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
                                                    @if (!empty($yesterdayTotalSalePrice))
                                                    Yesterday Sale
                                               </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $yesterdayTotalSalePrice }}</div>
                                                @endif
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
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@if (!empty($thisMonthTotalSalePrice))
                                                   This Month Sale

                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $thisMonthTotalSalePrice }}</div>
                                                    </div>
                                                </div>
                                                @endif
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
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">  @if (!empty($lastMonthTotalSalePrice)) {{ $lastMonthTotalSalePrice }}</div>
                                            </div>
                                            @endif
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
        <div class="heading" style="margin-top:10px;">
            <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary">SYC</button>
        </div>

        <table id="dataTable" class="display" style="width:100%">
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
                                    <td><a href="{{ $salesKey->takealot_url }}" target="_blank"><img src="{{ $salesKey->takealot_url }}"></a></td>
                                    <td> {{ $salesKey->product_title }}</td>
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
                    $value = $daysDifference * $salesKey->selling_price; // Adjust the calculation as needed
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
                    $value = $daysDifference * $salesKey->selling_price; // Adjust the calculation as needed
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
    </section>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
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
