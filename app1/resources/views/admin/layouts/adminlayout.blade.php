<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.component.style')
    @yield('style')
    <style>
        body{
            /* font-family: sans-serif; */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body:not(.sidebar-mini) .sidebar-style-3 {
            background-color: #198754;
        }
        /* .page-loader-wrapper {
            background: #198754 !important;
        } */
        body.layout-4 .navbar .nav-link {
            color: #198754;
        }
        body {
            color: #050505;
        }
        body.layout-4 .navbar .nav-link.nav-link-user, body.layout-4 .navbar .nav-link {
            color: #2ca56cc9;
        }
        a.dropdown-item:active, a.dropdown-item:focus{
            background-color: #187a4c;
        }
        div.dataTables_wrapper div.dataTables_filter input:focus {
            background-color: white;
        }
        .form-control:focus {
            background-color: white;
        }
        .page-item.active .page-link {
            background-color: #187a4c;
            border-color: #187a4c;
        }

        .bg-primary{
            background-color: #198754 !important;
        }
        /* .custom-control-label::before{
            background-color:#198754 !important
        } */
        .modal-backdrop.show {
            z-index: 1 !important;
        }
        body.layout-4 .main-sidebar {
            background-color: #187a4c;
        }
        body.sidebar-mini .main-sidebar .sidebar-menu>li>a .fas{
            color: white;
        }
        .main-sidebar .sidebar-brand a{
            color: white;
        }
        /* .navbar-bg{
            background-color: #d1d1d1 !important;
        } */

    </style>
</head>
<body class="layout-4">
    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <span class="loader"><span class="loader-inner"></span></span>
    </div> --}}

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <!-- Start app top navbar -->
            @if (!isset($hideNavbar) || !$hideNavbar)
            @include('admin.component.navbar')
            @endif

            <!-- Start main left sidebar menu -->
            {{-- @include('admin.component.sidebar') --}}
            @if (!isset($hideSidebar) || !$hideSidebar)
            @include('admin.component.sidebar')
            @endif


            @yield('main-content')


       

        </div>
    </div>

    <!-- Start app javascript part -->

    @include('admin.component.javascript')
    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($errors->any())
    <script>
        let errorMessages = @json($errors->all());

        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `<ul style="text-align: left;">${errorMessages.map(e => `<li>${e}</li>`).join('')}</ul>`,
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
        });
    </script>
@endif

</body>
</html>
