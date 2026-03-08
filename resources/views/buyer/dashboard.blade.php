<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Demo: Tables - Basic Tables | Sneat - Bootstrap Dashboard FREE</title>

    <meta name="description" content="" />

    @include('partials.head')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('components.menu', ['page' => 'dashboard'])
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('components.navbar', ['page' => 'dashboard'])
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Basic Bootstrap Table -->
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-header">Product List</h5>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <div class="d-flex gap-10 p-10">
                                    @foreach ($products as $product)
                                        <div class="text-center cart-index" style="cursor: pointer;"
                                            data-id="{{ $product->id }}">
                                            <img src="{{ asset('storage/images/' . $product->product_image) }}"
                                                alt="" style="height:100px;width:100px;border-radius: 10px;">
                                            <h6>{{ $product->product_name }}</h6>
                                            <h5>{{ $product->product_price }}</h5>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl">
                                <div
                                    class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                    <div class="mb-2 mb-md-0">
                                        ©
                                        <script>
                                            document.write(new Date().getFullYear());
                                        </script>
                                        , made with ❤️ by
                                        <a href="https://themeselection.com" target="_blank"
                                            class="footer-link">ThemeSelection</a>
                                    </div>
                                    <div class="d-none d-lg-inline-block">
                                        <a href="https://themeselection.com/item/category/admin-templates/"
                                            target="_blank" class="footer-link me-4">Admin Templates</a>

                                        <a href="https://themeselection.com/license/" class="footer-link me-4"
                                            target="_blank">License</a>
                                        <a href="https://themeselection.com/item/category/bootstrap-admin-templates/"
                                            target="_blank" class="footer-link me-4">Bootstrap Dashboard</a>

                                        <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                                            target="_blank" class="footer-link me-4">Documentation</a>

                                        <a href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free/issues"
                                            target="_blank" class="footer-link">Support</a>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        @include('partials.corejs')

        <script>
    
            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('getCartProducts') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res['counter'] && res['counter'] > 0) {
                            $(".cart").append('<span style="color: red;" class="counter">' + res[
                                'counter'] + '</span>')
                        }
                    }
                });


                $(".edit").on("click", function(event) {
                    event.preventDefault();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getProductById') }}",
                        datatype: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: $(this).data('product-id')
                        },
                        success: function(response) {
                            $('#product_name').val(response['product_name']);
                            $('#product_price').val(response['product_price']);
                            $('#quantity').val(response['quantity']);
                            $("#createProductModel").modal("show");
                            $("#productModel").attr("action", "{{ route('updateProduct') }}");
                            $('#product_id').val(response['id']);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Request failed: " + textStatus);
                        }
                    })
                });
            });

            $(".cart-index").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('addToCart') }}",
                    dataType: "json",
                    data: {
                        "product_id": $(this).data('id')
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res['status']) {
                            var val = $(".cart").find(".counter").html();
                            $(".cart").find(".counter").html(++val);
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    }
                });

            });
        </script>
</body>

</html>
