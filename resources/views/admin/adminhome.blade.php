@extends('layouts.sidebar')
@section('content')
<style>
    .chart-container {
        max-width: 100%;
        margin: 20px 0;
    }
    .card-header {
        background-color: #4E73DF;
        color: #fff;
    }
</style>
<div class="container-fluid">


    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <div class="row">
            <!-- First Column for Average Sales Price Chart -->
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Average Sales Price</h5>
                    <div class="card-body chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Second Column for Daily Sales Chart -->
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Daily Sales</h5>
                    <div class="card-body chart-container">
                        <canvas id="dailySale"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include Chart.js script only once -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- JavaScript for Average Sales Price Chart -->
        <script>
            var ctx1 = document.getElementById('salesChart').getContext('2d');
            var data1 = {
                labels: {!! json_encode(array_keys($averageData)) !!},
                datasets: [{
                    label: 'Average Sales Price',
                    data: {!! json_encode(array_values($averageData)) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            var options1 = {
                scales: {
                    x: [{
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM D'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }],
                    y: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Sales Price'
                        }
                    }]
                }
            };

            var salesChart1 = new Chart(ctx1, {
                type: 'line',
                data: data1,
                options: options1
            });
        </script>

        <script>
            var ctx1 = document.getElementById('daliySale').getContext('2d');
            var data1 = {
                labels: {!! json_encode(array_keys($averageData)) !!},
                datasets: [{
                    label: 'Average Sales Price',
                    data: {!! json_encode(array_values($averageData)) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            var options1 = {
                scales: {
                    x: [{
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM D'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }],
                    y: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Sales Price'
                        }
                    }]
                }
            };

            var salesChart1 = new Chart(ctx1, {
                type: 'line',
                data: data1,
                options: options1
            });
        </script>
        <script>
            // var ctx2 = document.getElementById('dailySale').getContext('2d');
            // var data2 = {
            //     labels: {!! json_encode($dates) !!},
            //     datasets: [{
            //         label: 'Daily Sales',
            //         data: {!! json_encode($salesTotals) !!},
            //         backgroundColor: 'rgba(54, 162, 235, 0.2)',
            //         borderColor: 'rgba(54, 162, 235, 1)',
            //         borderWidth: 2,
            //         pointRadius: 5,
            //         pointBackgroundColor: 'rgba(54, 162, 235, 1)',
            //         pointBorderColor: '#fff',
            //         pointBorderWidth: 2,
            //         pointHoverRadius: 6,
            //         pointHoverBackgroundColor: 'rgba(54, 162, 235, 1)',
            //         pointHoverBorderColor: '#fff',
            //         pointHoverBorderWidth: 2,
            //     }]
            // };

            // var options2 = {
            //     scales: {
            //         x: [{
            //             type: 'time',
            //             time: {
            //                 unit: 'day',
            //                 displayFormats: {
            //                     day: 'MMM D'
            //                 }
            //             },
            //             title: {
            //                 display: true,
            //                 text: 'Date',
            //                 fontSize: 16
            //             },
            //             ticks: {
            //                 maxRotation: 0,
            //                 autoSkip: true,
            //                 maxTicksLimit: 10,
            //                 fontSize: 12
            //             }
            //         }],
            //         y: [{
            //             ticks: {
            //                 beginAtZero: true,
            //                 callback: function(value, index, values) {
            //                     return '$' + value; // Prefix '$' to y-axis labels
            //                 }
            //             },
            //             scaleLabel: {
            //                 display: true,
            //                 labelString: 'Sales Total',
            //                 fontSize: 16
            //             },
            //             gridLines: {
            //                 color: 'rgba(0, 0, 0, 0.1)' // Light gray gridlines
            //             }
            //         }]
            //     },
            //     legend: {
            //         display: false
            //     },
            //     tooltips: {
            //         callbacks: {
            //             label: function(tooltipItem, data) {
            //                 return '$' + tooltipItem.yLabel.toFixed(2); // Prefix '$' to tooltip labels
            //             }
            //         }
            //     }
            // };

            // var salesChart2 = new Chart(ctx2, {
            //     type: 'line',
            //     data: data2,
            //     options: options2
            // });
        </script>

        <div class="row layout-top-spacing">
            @php
            $salesData = DB::table('sales')
                ->where('created_at', '>=', now()->subDays(30)) // Filter sales from the last 30 days
                ->orderBy('quantity', 'desc')
                ->limit(10)
                ->get();
            @endphp

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="card">
                    <h5 class="card-header">Top Selling Products in the Last 30 Days</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salesData as $sale)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="align-self-center">
                                                    <p class="mb-0">{{ $sale->product_title }}</p>
                                                    <p class="text-primary mb-0">{{ $sale->order_item_id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $sale->selling_price }}</td>
                                        <td class="text-center">{{ $sale->quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="card">
                    <h5 class="card-header">Return Products</h5>
                    @php
                    $returnData = DB::table('sales')
                        ->where('sale_status', '=', 'Returned') // Filter by sale_status equal to 'Returned'
                        ->orderBy('quantity', 'desc') // Order by return quantity in descending order
                        ->limit(10)
                        ->get();
                    @endphp
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Return</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($returnData as $return)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="align-self-center">
                                                    <p class="mb-0">{{ $return->product_title }}</p>
                                                    <p class="text-primary mb-0">{{ $return->order_item_id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $return->selling_price }}</td>
                                        <td class="text-center">{{ $return->quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; POS 2023</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


@endsection
