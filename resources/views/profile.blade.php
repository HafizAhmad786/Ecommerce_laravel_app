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
            @include("components.menu",['page'=>'profile'])
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-align-top">
                                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="javascript:void(0);"><i
                                                    class="icon-base bx bx-user icon-sm me-1_5"></i>
                                                Account</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                                    class="icon-base bx bx-bell icon-sm me-1_5"></i>
                                                Notifications</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages-account-settings-connections.html"><i
                                                    class="icon-base bx bx-link-alt icon-sm me-1_5"></i>
                                                Connections</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card mb-6">
                                    <!-- Account -->
                                    <div class="card-body pt-4">
                                        <form id="formAccountSettings" action="{{ route('updateUserInfor') }}"
                                            method="POST">
                                            @csrf
                                            <div class="row g-6">
                                                <div class="col-md-6">
                                                    <label for="firstName" class="form-label">User Name</label>
                                                    <input class="form-control" type="text" id="firstName" name="name"
                                                        value="{{ $user->name }}" autofocus />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lastName" class="form-label">User Email</label>
                                                    <input class="form-control" type="text" id="email" name="email"
                                                        value="{{ $user->email }}" placeholder="john.doe@example.com"
                                                        readonly />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Role</label>
                                                    <input class="form-control" type="text" name="role" id="lastName"
                                                        value="{{ $user->role }}" readonly />
                                                </div>
                                                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                            </div>
                                            <div class="mt-6">
                                                <button type="submit" class="btn btn-primary me-3">
                                                    Save changes
                                                </button>
                                                <a href="{{ route('dashboard') }}"
                                                    class="btn btn-outline-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /Account -->
                                </div>
                                <div class="card">
                                    <h5 class="card-header">
                                        Delete Account
                                    </h5>
                                    <div class="card-body">
                                        <div class="mb-6 col-12 mb-0">
                                            <div class="alert alert-warning">
                                                <h5 class="alert-heading mb-1">
                                                    Are you sure you want to
                                                    delete your account?
                                                </h5>
                                                <p class="mb-0">
                                                    Once you delete your
                                                    account, there is no
                                                    going back. Please be
                                                    certain.
                                                </p>
                                            </div>
                                        </div>
                                        <form id="formAccountDeactivation" onsubmit="return false;">
                                            <div class="form-check my-8 ms-2">
                                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                                    id="accountActivation" />
                                                <label class="form-check-label" for="accountActivation">I confirm my
                                                    account
                                                    deactivation</label>
                                            </div>
                                            <button type="submit" class="btn btn-danger deactivate-account">
                                                Deactivate Account
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(
                                            new Date().getFullYear(),
                                        );
                                    </script>
                                    , made with ❤️ by
                                    <a href="https://themeselection.com" target="_blank"
                                        class="footer-link">ThemeSelection</a>
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="https://themeselection.com/item/category/admin-templates/" target="_blank"
                                        class="footer-link me-4">Admin Templates</a>

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

    @include("partials.corejs")
</body>

</html>