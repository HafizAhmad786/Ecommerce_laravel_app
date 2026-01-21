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

  @include("partials.head")
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      @include("components.menu",['page'=>'dashboard'])
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        @include("components.navbar")
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Bootstrap Table -->
            <div class="card">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header">Product List</h5>
                <button type="button" class="btn btn-primary mx-6" data-bs-toggle="modal"
                  data-bs-target="#createProductModel">
                  Add Product
                </button>

              </div>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Product Name</th>
                      <th>Product price</th>
                      <th>Quantity</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0" id="table_id">
                    @foreach($products as $product)
                    <tr>
                      <td>
                        <img src="{{ asset('storage/images/'.$product->product_image) }}" alt="" width="40px"
                          height="40px">
                      </td>
                      <td>{{ $product->product_name }}</td> <!-- product name-->
                      <td>{{ $product->product_price }}</td> <!-- product price-->
                      <td><span class="badge bg-label-primary me-1">{{ $product->quantity }}</span></td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item edit" href="javascript:void(0);"
                              data-product-id="{{ $product->id }}"><i class="icon-base bx bx-edit-alt me-1"
                                data-bs-toggle="modal" data-bs-target="#createProductModel"></i>
                              Edit</a>
                            <a id="trash" class="dropdown-item" href="{{ route('deleteProduct', $product->id) }}"><i
                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforEach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Modal -->

            <div class="modal fade " id="createProductModel" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="{{ route('createProduct') }}" method="post" id="productModel" class="m-4"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                      <label for="Product Image" class="form-label">Product Image</label>
                      <input type="file" class="form-control" value="{{ old('product_image') }}" id="product_image"
                        name="image" placeholder="Choose your image" autofocus />
                      <span style="color:red;"></span>
                    </div>
                    <input type="hidden" name="product_id" id="product_id" />
                    <div class="mb-6">
                      <label for="Product Name" class="form-label">Product Name</label>
                      <input type="text" class="form-control" value="{{ old('product_name') }}" id="product_name"
                        name="product_name" placeholder="Enter product name" autofocus />

                      <span style="color:red;"></span>
                    </div>
                    <div class="mb-6">
                      <label for="product_price" class="form-label">Product Price</label>
                      <input type="number" class="form-control" id="product_price" value="{{ old('product_price') }}"
                        name="product_price" placeholder="Enter product price" />
                      <span style="color:red;"></span>
                    </div>
                    <div class="form-password-toggle">
                      <label class="form-label" for="quantity">Quantity</label>
                      <div class="input-group input-group-merge mb-4">
                        <input type="number" id="quantity" value="{{ old('quantity') }}" class="form-control"
                          name="quantity" />
                      </div>
                      <span style="color: red;"></span>
                    </div>
                    <button class="btn btn-primary d-grid w-100">Add Product</button>
                  </form>

                </div>
              </div>
            </div>
            <!--/end model-->

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
                    <a href="https://themeselection.com" target="_blank" class="footer-link">ThemeSelection</a>
                  </div>
                  <div class="d-none d-lg-inline-block">
                    <a href="https://themeselection.com/item/category/admin-templates/" target="_blank"
                      class="footer-link me-4">Admin Templates</a>

                    <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://themeselection.com/item/category/bootstrap-admin-templates/" target="_blank"
                      class="footer-link me-4">Bootstrap Dashboard</a>

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
    @include("partials.corejs")

    <script>
      $(document).ready(function () {
        $(".edit").on("click", function (event) {
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
            success: function (response) {
              $('#product_name').val(response['product_name']);
              $('#product_price').val(response['product_price']);
              $('#quantity').val(response['quantity']);
              $("#createProductModel").modal("show");
              $("#productModel").attr("action", "{{ route('updateProduct') }}");
              $('#product_id').val(response['id']);
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.error("Request failed: " + textStatus);
            }
          })
        });
      });
    </script>
    <!-- <script>
      

      $("#edit").on("submit", function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
          type: "POST",
          url: "",
          datatype: "json",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: formData.append('id', $("#product_id").val()),
          success: function (response) {
            console.log(response);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Request failed: " + textStatus);
          }
        })
      });



      $("#product_model").on("submit", function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
          type: "POST",
          url: "",
          data: formData,
          contentType: false,
          processData: false,
          datatype: "json",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            console.log(response);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Request failed: " + textStatus);
          }
        })
      });

    </script> -->
</body>

</html>