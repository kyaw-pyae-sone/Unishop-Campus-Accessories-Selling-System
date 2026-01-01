<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield("title")</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        #wrapper {
            width: 100vw;
            position: absolute;
            top: 0;
        }
    </style>

</head>

<body id="page-top" class="overflow-x-hidden">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route("admin#dashboard") }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Code Lab Studio</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin#dashboard") }}"><i class="fas fa-fw fa-table"></i><span>Dashboard </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route("category#list") }}"><i class="fa-solid fa-circle-plus"></i></i><span>Category </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route("product#create") }}"><i class="fa-solid fa-plus"></i></i><span>Add Products </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route("product#list")  }}"><i class="fa-solid fa-layer-group"></i><span>Product List </span></a>
            </li>


            @if(Auth::user() -> role == "superadmin")
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("payment#list") }}"><i class="fa-solid fa-credit-card"></i><span>Payment Method </span></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route("sale#list") }}"><i class="fa-solid fa-list"></i><span>Sale Information </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route("order#list") }}"><i class="fa-solid fa-cart-shopping"></i><span>Order Board </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route("message#list") }}"><i class="fa-solid fa-message"></i><span>Feedbacks
                        <span class="badge text-bg-danger">
                            @if($unreadCount > 0)
                                {{ $unreadCount }}
                            @endif
                        </span></span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route("profile#renderPasswordChangePage") }}"><i class="fa-solid fa-lock"></i></i></i><span>Change Password </span></a>
            </li>

            <li class="nav-item">
                <form action="{{ route("logout") }}" method="post">
                    @csrf
                    <span class="nav-link">
                        <button type="submit" class="btn bg-dark text-white"><i
                                class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </span>
                </form>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow me-5">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user() -> name ? Auth::user() -> name : Auth::user() -> nickname }}</span>
                                <img class="img-profile rounded-circle" src="{{ Auth::user() -> profile == null ? asset("admin/img/undraw_profile.svg") : asset("/admin/profile/" . Auth::user() -> profile ) }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route("profile#edit") }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                @if(Auth::user() -> role == "superadmin")
                                    <a class="dropdown-item" href="{{ route("account#create") }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Add New Admin Account
                                    </a>
                                    <a class="dropdown-item" href="{{ route("account#listAdmin") }}">
                                        <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Admin List
                                    </a>

                                    <a class="dropdown-item" href="{{ route("account#listUser") }}">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        User List
                                    </a>
                                @endif


                                <a class="dropdown-item" href="{{ route("profile#renderPasswordChangePage") }}">
                                    <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <form action="{{ route("logout") }}" method="post">
                                        @csrf
                                        <input type="submit" class="btn btn-dark text-white w-100" value="Logout">
                                    </form>
                                </span>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @include('sweetalert::alert')

                @yield("content")


            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>


{{--    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>--}}

    <!-- Page level custom scripts -->
{{--    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>--}}
{{--    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>--}}

    {{-- Sweetalert CDN JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{--  Chart.js CDNjs  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{--  Chart.js Data Labels plugins CDNjs  --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    {{--    JQuery CDNJs--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield("js-script")

    <script type="text/javascript">
        function loadFile(event){
            const reader = new FileReader();

            reader.onload = function(){
                const imgTag = document.getElementById("output");

                imgTag.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>
