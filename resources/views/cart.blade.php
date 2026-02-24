<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>
        Demo: Account settings - Account | Sneat - Bootstrap Dashboard FREE
    </title>

    <meta name="description" content="" />

    @include("partials.head")
</head>

<style>
    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #04AA6D;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        animation: spin 1s linear infinite;
        /* Animation definition */
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include("components.menu",['page'=>'cart'])
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include("components.navbar")

                <!-- / Navbar -->

                <!-- Content wrapper -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show container">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show container">
                    {{ session('error') }}
                </div>
                @endif


                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-header">Product List</h5>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Product price</th>
                                        <th class="text-center">Total Quantity</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="table_id">
                                    @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/images/'.$product->product_image) }}" alt=""
                                                width="40px" height="40px">
                                        </td>
                                        <td class="text-center">{{ $product->product_name }}</td> <!-- product name-->
                                        <td class="text-center price">{{ $product->product_price }}</td>
                                        <!-- product price-->
                                        <td class="text-center"><span
                                                class="badge bg-label-primary me-1 total_quantity">{{ $product->quantity
                                                }}</span></td>
                                        <td class="d-flex justify-content-center">
                                            <div class="d-flex gap-6 ">
                                                <button class="btn btn-danger decrement">-</button>
                                                <p
                                                    class="mb-0 d-flex align-items-center justify-content-center quantity">
                                                    1
                                                </p>
                                                <button class="btn btn-primary increment">+</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <h3 class="text-center">Cart is Empty</h3>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between container ">
                                <h4>
                                    Total Price
                                </h4>
                                <div class="d-flex justify-content-end align-items-center">
                                    <p>$</p>
                                    <p class="d-flex align-items-center justify-content-center total_price"
                                        style="padding-right: 51px;">0.00</p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <form method="POST" id="stripe-form" class="container mt-4">
                    @csrf
                    <input type="hidden" name="price" id="total_price" value="0">
                    <input type="hidden" id="stripe-token" name="stripeToken">
                    <div id="card-element" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center mt-4">
                        <div class="loader d-none"></div>
                        <span class="span me-1">$</span>
                        <span class="span total_price" id="total_price_display">0.00</span>
                    </button>

                </form>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @include("partials.corejs")

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        //stripe 
        var stripe = Stripe("{{ config('stripe.stripe.public') }}");
        var elements = stripe.elements();
        var cardElement = elements.create("card");
        cardElement.mount("#card-element");

        $("#stripe-form").submit(function (e) {
            e.preventDefault();

            $(".loader").removeClass("d-none").addClass("d-block");
            $(".span").addClass("d-none");

            var form = this;
            var quantity = [];


            var tableBody = $("#table_id tr").each(function (index) {
                quantity.push(parseFloat($(this).find(".quantity").text()));
            });



            stripe.createToken(cardElement).then(function (result) {

                if (result.error) {
                    $(".loader").addClass("d-none").removeClass("d-block");
                    $(".span").removeClass("d-none").addClass("d-block");
                    return;
                }

                $("#stripe-token").val(result.token.id);
                var formData = new FormData(form);
                quantity.forEach(qty => {
                    formData.append('quantity[]', qty);
                });
                $.ajax({
                    url: "{{ route('makePayment') }}",
                    data: formData,
                    dataType: "json",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result['status'] == true) {
                            $(".loader").addClass("d-none");
                            $(".span").removeClass("d-none");
                            Swal.fire({
                                title: "Success",
                                text: result['message'],
                                icon: "success"
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            $(".loader").addClass("d-none");
                            $(".span").removeClass("d-none");
                            Swal.fire({
                                title: "Error",
                                text: result['message'],
                                icon: "error"
                            });

                        }
                    },
                    error: function (xhr, status, error) {
                        $(".loader").addClass("d-none");
                        $(".span").removeClass("d-none");
                        Swal.fire({
                            title: "Error",
                            text: xhr.responseJSON.message,
                            icon: "error"
                        });
                    }
                });
            });
        });

        $(document).ready(function () {
            var totalPrice = 0.00;
            var tableBody = $("#table_id tr").each(function (index) {
                var price = parseInt($(this).find(".price").text());
                var quantity = parseFloat($(this).find(".quantity").text());
                totalPrice += (price * quantity);
            });

            $(".total_price").text(totalPrice);
            $("#total_price").val(totalPrice);

        });


        //increment the quantity
        $(".increment").on("click", function () {
            let quantityEl = $(this).closest("td").find(".quantity");
            let totalPrice = parseInt($(".total_price").html());
            let price = $(this).closest("tr").find(".price").text();
            let totalQuantity = $(this).closest("tr").find(".total_quantity").text();
            let quantity = parseInt(quantityEl.text());
            if (quantity < parseInt(totalQuantity)) {
                quantity++;
                totalPrice += parseInt(price);
            }
            $(".total_price").text(totalPrice);
            $("#total_price").val(totalPrice);
            quantityEl.text(quantity);
        });

        //decrement the quanity
        $(".decrement").on("click", function () {
            var quantityEl = $(this).siblings(".quantity");
            let totalPrice = parseInt($(".total_price").html());
            let price = $(this).closest("tr").find(".price").text();
            var quantity = parseInt(quantityEl.text());
            if (quantity > 1) {
                quantity--;
                totalPrice -= parseInt(price);
            }
            quantityEl.text(quantity);
            $("#total_price").val(totalPrice);
            $(".total_price").text(totalPrice);
        });


    </script>
</body>

</html>