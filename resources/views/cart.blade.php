<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Demo: Account settings - Account | Sneat - Bootstrap Dashboard FREE
    </title>

    <meta name="description" content="" />

    @include("partials.head")
</head>

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
                @include("components.navbar",['page'=>'cart'])

                <!-- / Navbar -->

                <!-- Content wrapper -->
                @if(session('success'))
                <div class="alert alert-success container">
                    {{ session('success') }}
                </div>
                @endif


                <div class="card">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-header">Product List</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Product price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="table_id">
                                @foreach($carts as $cart)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/images/'.$cart->product_image) }}" alt=""
                                            width="40px" height="40px">
                                    </td>
                                    <td>{{ $cart->product_name }}</td> <!-- product name-->
                                    <td>{{ $cart->product_price }}</td> <!-- product price-->
                                    <td><span class="badge bg-label-primary me-1">{{ $cart->quantity
                                            }}</span></td>
                                    <td>
                                        <a class="dropdown-item edit" href="javascript:void(0);"
                                            data-product-id="{{ $cart->id }}"><i class="icon-base bx bx-edit-alt me-1"
                                                data-bs-toggle="modal" data-bs-target="#createProductModel"></i>
                                            Edit</a>
                                        <a id="trash" class="dropdown-item"
                                            href="{{ route('deleteProduct', $cart->id) }}"><i
                                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <form action="{{ route('makePayment') }}" method="POST" id="stripe-form" class="container mt-4">
                    @csrf
                    <input type="hidden" name="price" value="200">
                    <input type="hidden" id="stripe-token" name="stripeToken">
                    <div id="card-element" class="form-control">
                    </div>
                    <button type="button" class="btn btn-primary mt-4" onclick="createToken()" id="submit-btn">Pay
                        $200</button>
                </form>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @include("partials.corejs")
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("{{ config('stripe.stripe.public') }}");
        var elements = stripe.elements();
        var cardElement = elements.create("card");
        cardElement.mount("#card-element");
        function createToken() {
            stripe.createToken(cardElement).then(function (result) {
                if (result.token) {
                    document.getElementById("stripe-token").value = result.token.id;
                    document.getElementById("stripe-form").submit();
                }
            });
        }


    </script>
</body>

</html>