<!DOCTYPE html>
<html lang="en">

<!-- auth-login.html  Tue, 07 Jan 2020 03:39:47 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Pnac Login</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ url('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/modules/fontawesome/css/all.min.css') }}">

    {{-- Icon CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ url('admin/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/css/components.min.css') }}">
    {{-- alert --}}
    <link rel="stylesheet" href="{{ url('admin/assets/modules/izitoast/css/iziToast.min.css') }}">

    <style>
        .btn-success {
            background-color: #198754;
        }

        .btn-success:active {
            background-color: #198754 !important;
        }

        .btn-success:hover {
            background-color: #198754 !important;
        }

        .btn-success:focus {
            background-color: #198754 !important;
        }

        body.layout-4 .card,
        body.layout-4 .article {
            background-color: #ffffff5d;
            border: none
        }

        body {
            /* background-image: url('images/background.jpg'); */
            background: linear-gradient(90deg, rgba(87, 199, 133, 1) 33%, rgba(83, 232, 237, 1) 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: sans-serif;
        }

        .form-control:focus {
            background-color: white;
        }

        .card.card-primary {
            background-color: #ffffff5d;
        }
    </style>
</head>

<body class="layout-4">

    <div id="app">
        <section class="section">
            <div class="container mt-5 pt-5">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4 alert alert-success" :status="session('status')" />

                <x-input-error class="mb-4 alert alert-danger" :messages="session('messages')" />
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                        <div class="card card-primary">
                            <div class="login-brand">
                                <img src="{{ asset('images/pnac.png') }}" alt="logo" width="100">
                            </div>
                            {{-- <div class="card-header">
                                <h4>Login</h4>
                            </div> --}}
                            @if (session('success'))
                                <div class="alert alert-success w-100">{{ session('success') }}</div>
                            @endif
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="form-group">

                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="form-control block mt-1 w-full"
                                            type="email" name="email" :value="old('email')" tabindex="1" required
                                            autofocus autocomplete="username" />
                                        {{-- <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" /> --}}

                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <x-input-label for="password" :value="__('Password')" />
                                            {{-- <div class="d-flex"> --}}
                                            <x-text-input id="password" class="form-control block mt-1 w-full"
                                                type="password" name="password" tabindex="2" required
                                                autocomplete="current-password" />

                                            <span class="toggle-password"
                                                style="cursor: pointer; position: relative; left:280px; bottom:30px;"
                                                onclick="togglePasswordVisibility()"><i
                                                    class="fa-solid fa-eye-slash eye-slash1 eye-fa-fa curs"></i></span>
                                        </div>
                                        {{-- </div> --}}
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                    </div>



                                    <div class="form-group flex items-center justify-end mt-4">
                                        @if (Route::has('password.request'))
                                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif

                                        <x-primary-button class="ms-3 btn btn-success btn-lg btn-block" tabindex="4">
                                            {{ __('Log in') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                                <div class="mt-0 text-center">
                                    Don't have an account? <a href="{{ route('register') }}">Create One</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ url('admin/assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ url('admin/js/CodiePie.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ url('admin/assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ url('admin/assets/modules/chart.min.js') }}"></script>
    <script src="{{ url('admin/assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ url('admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ url('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ url('admin/js/page/index.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ url('admin/js/scripts.js') }}"></script>
    <script src="{{ url('admin/js/custom.js') }}"></script>

    {{-- alert --}}
    <script src="{{ url('admin/assets/modules/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ url('admin/js/page/modules-toastr.js') }}"></script>

    {{-- sweet alert --}}
    <script src="{{ url('admin/js/page/modules-sweetalert.js') }}"></script>
    <script src="{{ url('admin/assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if ($errors->any())
        <script>
            let errorMessages = @json($errors->all());

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `<ul style="text-align: left;">${errorMessages.map(e => `<li>${e}</li>`).join('')}</ul>`,
            });
            // Swal.fire("SweetAlert2 is working!");
        </script>
    @endif

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const passwordToggle = document.querySelector('.toggle-password i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

<!-- auth-login.html  Tue, 07 Jan 2020 03:39:47 GMT -->

</html>
{{-- </x-guest-layout> --}}
