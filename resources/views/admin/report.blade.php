@extends('layouts.sidebar')
@section('content')
<style>
.form-control {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    width: 100%;
    margin: 5px 0;
}
#custom-date-range {
    display: none;
}
svg {
    height: 25px;
    overflow: hidden;
    vertical-align: middle;
}
.btn-primary {
    background-color: #007BFF;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}
.btn-primary:hover {
    background-color: #0056b3;
}
.card {
    width: 100%;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s;
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

</style>


<section class="container" style=" background-color:white;margin-top:20px;">
<div id="selectreportstatus" class="content-body">
    <div class="container-fluid">
      <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Takealot Report through Sale Status</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('report') }}" method="get" class="form-inline">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="form-group mb-2">
                                <label for="date_range" class="mr-2">Date Range:</label>
                                <select name="date_range" id="date_range" class="form-control p-0">
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="last7days">Last 7 Days</option>
                                    <option value="last30days">Last 30 Days</option>
                                    <option value="thismonth">This Month</option>
                                    <option value="lastmonth">Last Month</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group mb-2">
                                <label for="status" class="mr-2">Status:</label>
                                <select name="status" id="status" class="form-control p-0 w-100">
                                    <option value="">All</option>
                                    @foreach ($statuses as $statusOption)
                                        <option value="{{ $statusOption }}" {{ $statusOption == $request->input('status') ? 'selected' : '' }}>
                                            {{ $statusOption }}
                                        </option>
                                    @endforeach
                                     <option value="Buyable">Top Selling</option>
    <option value="Returned">Top Returning</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-2" id="custom-date-range">
                               <div class="row">
                             <div class="col-md-6">
                                <label for="start_date" class="mr-2" style="justify-content: left;">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control w-100">
                             </div>
                             <div class="col-md-6">
                                <label for="end_date" class="mr-2" style="justify-content: left;">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control w-100">
                             </div>
                               </div>
                              
                            </div>
                        </div>
                       
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary mt-3 p-2" style="font-size: 15px;">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                @if($salesData->count() > 0)
                    <table id="" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>TSIN</th>
                                <th>QTY</th>
                                <th>Order ID</th>
                                <th>SKU</th>
                                <th>DC</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Top Selling</th>
                                <th>Top Returned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Iterate through paginated data -->
                            @foreach ($salesData as $salesRecord)
                                <tr>
                                    <td>{{ $salesRecord->order_date }}</td>
                                    <td>
                                        {{ $salesRecord->product_title }}
                                        <a href="{{ $salesRecord->product_title }}" target="_blank">
                                            <span class="badge badge-warning"><i class="fa fa-globe"></i></span>
                                        </a>
                                    </td>
                                    <td>{{ $salesRecord->tsin }}</td>
                                    <td>{{ $salesRecord->quantity }}</td>
                                    <td>{{ $salesRecord->order_id }}</td>
                                    <td>{{ $salesRecord->sku }}</td>
                                    <td>{{ $salesRecord->dc }}</td>
                                    <td>{{ $salesRecord->sale_status }}</td>
                                    <td>{{ $salesRecord->selling_price }}</td>
                                    <td>
                                        @if ($salesRecord->sale_status === 'Shipped to Customer')
                                            <!-- Calculate and display the value for Shipped to Customer -->
                                            <?php
                                            $createdDate = \Carbon\Carbon::parse($salesRecord->order_date);
                                            $currentDate = \Carbon\Carbon::now();
                                            $daysDifference = $createdDate->diffInDays($currentDate);
                                            $value = $daysDifference + $salesRecord->quantity; // Adjust the calculation as needed
                                            ?>
                                            {{ $value }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if ($salesRecord->sale_status === 'Returned')
                                            <!-- Calculate and display the value for Returned -->
                                            <?php
                                            $createdDate = \Carbon\Carbon::parse($salesRecord->order_date);
                                            $currentDate = \Carbon\Carbon::now();
                                            $daysDifference = $createdDate->diffInDays($currentDate);
                                            $value = $daysDifference + $salesRecord->quantity; // Adjust the calculation as needed
                                            ?>
                                            {{ $value }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $salesData->appends(request()->query())->links() }}
                @else
                    <p>No data found</p>
                @endif
            </div>
        </div>
    </div>
</div>

                         

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>




    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        function setDates(dateRange) {
            const today = new Date();
            const endDate = today.toISOString().slice(0, 10);
            switch (dateRange) {
                case 'today':
                    $('#start_date').val(endDate);
                    $('#end_date').val(endDate);
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(today.getDate() - 1);
                    $('#start_date').val(yesterday.toISOString().slice(0, 10));
                    $('#end_date').val(yesterday.toISOString().slice(0, 10));
                    break;
                case 'last7days':
                    const last7Days = new Date(today);
                    last7Days.setDate(today.getDate() - 7);
                    $('#start_date').val(last7Days.toISOString().slice(0, 10));
                    $('#end_date').val(endDate);
                    break;
                case 'last30days':
                    const last30Days = new Date(today);
                    last30Days.setDate(today.getDate() - 30);
                    $('#start_date').val(last30Days.toISOString().slice(0, 10));
                    $('#end_date').val(endDate);
                    break;
                case 'thismonth':
                    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    $('#start_date').val(firstDayOfMonth.toISOString().slice(0, 10));
                    $('#end_date').val(endDate);
                    break;
                case 'lastmonth':
                    const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const lastDayOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                    $('#start_date').val(lastMonth.toISOString().slice(0, 10));
                    $('#end_date').val(lastDayOfLastMonth.toISOString().slice(0, 10));
                    break;
                case 'custom':
                    break;
            }
        }
        $('#date_range').on('change', function() {
            const selectedDateRange = $(this).val();
            setDates(selectedDateRange);
        });
        setDates('today');
    });
</script>


<script>
    $(document).ready(function() {
        function setDates(dateRange) {
            // ... Previous code ...

            if (dateRange === 'custom') {

                $('#custom-date-range').show();
            } else {
                // Hide the custom date range input fields
                $('#custom-date-range').hide();
            }
        }

        $('#date_range').on('change', function() {
            const selectedDateRange = $(this).val();
            setDates(selectedDateRange);
        });

        // Initial setup
        setDates('today');
    });
</script>


@endsection
