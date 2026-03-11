<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sales Records</title>

    @include('partials.head')
</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('components.menu', ['page' => 'sales'])
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('components.navbar')
                <!-- / Navbar -->

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-header">Sales</h5>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Url</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" id="table_id">
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="order_id">
                                                    {{ $order->id }}
                                                </td>
                                                <td>
                                                    {{ $order->created_at->format('l d Y') }}
                                                </td>
                                                <td>{{ $order->buyer->name }}</td>
                                                <td><span
                                                        class="badge bg-label-primary me-1">{{ $order->status }}</span>
                                                </td>
                                                <td>${{ $order->total_price }}</td>
                                                <td><a href="{{ $order->url }}">Url</a></td>
                                                <td><input type="button" class="btn btn-primary view" value="View">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade " id="ProductModelId" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <h4 class="modal-title text-center p-4">Order Items</h4>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Product Price</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" id="model_table">
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/end model-->
            </div>

        </div>


        @include('partials.corejs')

        <script>
            $(document).ready(function() {
                  var asset =  "{{ asset('storage/images') }}";

                $(".view").on("click", function() {
                    $.ajax({
                        url: "{{ route('getProducts') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "order_id": $(this).closest("tr").find(".order_id").text().trim()
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $("#ProductModelId").modal("show");
                            $("#model_table").html(""); // clear table data
                            response.products.forEach((res, index) => {
                                $("#model_table").append(`
                                    <tr>
                                        <td>
                                            <img src="${asset}/${res.product.product_image} " alt="" width="40px" height="40px">
                                        </td>
                                        <td>
                                            ${res.product.product_name}
                                        </td>
                                        <td>${res.product.product_price}</td>
                                        <td><span
                                                class="badge bg-label-primary me-1">${res.quantity}</span>
                                        </td>
                                    </tr>
                                `);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
</body>

</html>
