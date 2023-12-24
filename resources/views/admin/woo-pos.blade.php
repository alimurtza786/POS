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

<section class="container" style=" background-color:white;margin-top:20px;">
 <div class="heading" style="margin-top:10px;">
            <button style="margin-top: 33px; margin-bottom:20px;" class="btn btn-primary" onclick="download()">CSV</button>
            <button style="margin-top: 33px; margin-bottom:20px;" id="btn-primary" class="btn btn-primary" >SYC</button>
        </div>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Barcode</th>
                <th>Cost Price</th>
                <th>Selling Price</th>
                <th>Available Stock</th>
                <th>Rack No</th>
                <th>Stock handler</th>
                <th>Update</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td> <img src="public/no_image.jpg" width="80px"> </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->code }}</td>
                   <td>{{ number_format($product->price, 2) }}</td>
<td>{{ number_format($product->cost, 2) }}</td>
                    <td>{{ number_format($product->quantity, 2) }}</td>
                    <td>{{ $product->rack }}</td>
                    <td>{{ $product->stack_handler }}</td>
                    
<td>
     <button class="btn btn-sm btn-primary update-barcode" data-product-id="{{ $product->id }}" data-toggle="modal" data-target="#updateBarcodeModal">Update</button>
</td>
<td>
     <button class="btn btn-sm btn-info show-supplier"  data-toggle="modal" data-target="#supplierModal">Supplier</button>
</td>
                </tr>
                <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supplier Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="supplier-info">
                    <div class="supplier">
                        <span>Supplier 1:</span>
                        <span class="price">{{ $product->supplier1price }}</span>
                    </div>
                    <div class="supplier">
                        <span>Supplier 2:</span>
                        <span class="price">{{ $product->supplier2price }}</span>
                    </div>
                    <div class="supplier">
                        <span>Supplier 3:</span>
                        <span class="price">{{ $product->supplier3price }}</span>
                    </div>
                    <div class="supplier">
                        <span>Supplier 4:</span>
                        <span class="price">{{ $product->supplier4price }}</span>
                    </div>
                    <div class="supplier">
                        <span>Supplier 5:</span>
                        <span class="price">{{ $product->supplier5price }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
            @endforeach
        </tbody>
    </table>
   



    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2021</span>
            </div>
        </div>
    </footer>
 

    </div>
   

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateBarcodeModal" data-product-id="{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="updateBarcodeModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" id="newBarcode" value="" name="newBarcode">
                    </div>
                     <div class="form-group">
                        <label for="sellingPrice">Selling Price:</label>
                        <input type="text" class="form-control" value="" id="sellingPrice" name="sellingPrice">
                    </div>
                    <div class="form-group">
                        <label for="newRack">New Rack:</label>
                        <input type="text" class="form-control" value="" id="newRack" name="newRack">
                    </div>
                    <div class="form-group">
                        <label for="newStackHandler">New Stack Handler:</label>
                        <input type="text" class="form-control" id="newStackHandler" value="" name="newStackHandler">
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


 <script>
        let table = new DataTable('#myTable');
 $(document).ready(function() {
    $('.update-barcode').click(function() {
        var productId = $(this).data('product-id');
        $('#productId').val(productId);
        $('#resultContainer').hide(); 
    });

    $('#saveBarcodeButton').click(function() {
        var productId = $('#productId').val();
        var newBarcode = $('#newBarcode').val();
         var sellingPrice = $('#sellingPrice').val();
        var newRack = $('#newRack').val();
        var newStackHandler = $('#newStackHandler').val(); 
var updatedBarcodeData = {
                productId: $('#productId').val(),
                newBarcode: $('#newBarcode').val(),
                sellingPrice: $('#sellingPrice').val(),
                newRack: $('#newRack').val(),
                newStackHandler: $('#newStackHandler').val(),
            };
        $.ajax({
            type: 'POST',
            url: "{{ route('update-barcode1') }}",
            data: {
                _token: "{{ csrf_token() }}",
                productId: productId,
                newBarcode: newBarcode,
                sellingPrice : sellingPrice,
                newRack: newRack, 
                newStackHandler: newStackHandler 
            },
            success: function(data) {
                console.log(data);

                if (data.success) {
                    var updateButton = $('.update-barcode[data-product-id="' + productId + '"]');
                    updateButton.hide();

                    var priceDifference = data.priceDifference;
                    var resultContainer = $('#resultContainer');
                    var resultMessage = $('#resultMessage');

                    console.log(priceDifference);

                    if (priceDifference !== null) {
                        var resultContainer = $('.profit-loss-container[data-product-id="' + productId + '"]');
                        resultContainer.text('Profit/Loss: $' + priceDifference);
                    } else {
                        console.log('Price difference is null or invalid.');
                    }
                    console.log(updatedBarcodeData);

                    $('#updateBarcodeModal').modal('hide');
                } else {
                    alert('Failed to update barcode.');
                }
            },
            error: function() {
                alert('Error updating barcode.');
            }
        });
    });
});
    $(document).ready(function() {
        $('#calculateButton').click(function() {
            var barcode = $('#barcode').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('get-loss-profit') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    barcode: barcode
                },
                success: function(data) {
                    var priceDifference = data.priceDifference;
                    var resultContainer = $('#resultContainer');
                    var resultMessage = $('#resultMessage');
                    
                    if (priceDifference !== null) {
                        
                        resultMessage.html('Profit/Loss: $' + priceDifference);
                        resultContainer.show();
                    } else {
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
       $('.update-barcode').on('click', function() {
    var productId = $(this).data('product-id');
    $.ajax({
        url: '/get-product/' + productId,
        type: 'GET',
        success: function(data) {
            // Update the input fields in the modal with the fetched data
            $('#newBarcode').val(data.code);
            $('#sellingPrice').val(data.cost);
            $('#newRack').val(data.rack);
            $('#newStackHandler').val(data.stack_handler);
            $('#productId').val(data.id);
        },
        error: function(error) {
            console.log(error);
        }
    });
});
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
