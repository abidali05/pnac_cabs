<!DOCTYPE html>
<html lang="en">

<!-- errors-404.html  Tue, 07 Jan 2020 03:39:48 GMT -->
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>404 &mdash; CAB</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="{{ url('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('admin/assets/modules/fontawesome/css/all.min.css') }}">

<!-- CSS Libraries -->

<!-- Template CSS -->
<link rel="stylesheet" href="{{ url('admin/assets/css/style.min.css') }}">
<link rel="stylesheet" href="{{ url('admin/assets/css/components.min.css') }}">
</head>
<style>
    .text-success{
        color: #0d5e2c !important;
    }
</style>

<body class="layout-4">

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1 class="text-success">404</h1>
                    <div class="page-description text-black">
                        The page you were looking for could not be found.
                    </div>
                    <div class="page-search">
                        {{-- <form>
                            <div class="form-group floating-addon floating-addon-not-append">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-lg">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <div class="mt-3"><a href="{{ route('dashboard') }}">Back to Dashboard</a></div>
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5 text-black-50">© Copyright www.pnac.gov.pk. All Rights Reserved. Design: [PNAC]</div>
        </div>
    </section>
</div>

<!-- General JS Scripts -->
<script src="{{ url('admin/assets/bundles/lib.vendor.bundle.js') }}"></script>
<script src="{{ url('admin/js/CodiePie.js') }}"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="{{ url('admin/js/scripts.js') }}"></script>
<script src="{{ url('admin/js/custom.js') }}"></script>
</body>

<!-- errors-404.html  Tue, 07 Jan 2020 03:39:48 GMT -->
</html>
