{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
@csrf

<!-- Name -->
<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Email Address -->
<div class="mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />

    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
        {{ __('Already registered?') }}
    </a>

    <x-primary-button class="ms-4">
        {{ __('Register') }}
    </x-primary-button>
</div>
</form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<!-- auth-register.html  Tue, 07 Jan 2020 03:39:47 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Pnac Register</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ url('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ url('admin/assets/modules/jquery-selectric/selectric.css') }}">

    {{-- Icon CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin/assets/css/components.min.css') }}">

    <style>
        .form-control:focus {
            background-color: white;
        }

        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #198754 !important;
        }

        body {
            /* background-image: url('images/background.jpg'); */
            background: linear-gradient(90deg, rgba(87, 199, 133, 1) 33%, rgba(83, 232, 237, 1) 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: sans-serif;
        }

        body.layout-4 .card,
        body.layout-4 .article {
            background-color: #ffffff5d;
            border: none;
        }

    </style>
</head>

<body class="layout-4">

    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row  d-flex justify-content-center" >
                    <div class="col-12 col-sm-10  col-md-4 col-lg-4  col-xl-4 ">
                        <div class="card card-primary">
                            <div class="login-brand" style="margin-bottom: 15px !important">
                                <img src="{{ asset('images/pnac.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
                                {{-- <h4 class="mt-4">Register</h4> --}}
                            </div>
                            {{-- <div class="card-header">
                                <h4>Register</h4>
                            </div> --}}
                            <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="form-group col-12 m-0">
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                                        </div>

                              
                                        <div class="form-group col-12 m-0">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                                        </div>
                                    

                                        <div class="form-group col-12 m-0">
                                            <x-input-label for="password" :value="__('Password')" />

                                            <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                            <span class="toggle-password" style="cursor: pointer; position: absolute; right: 20px; top: 40px;" onclick="toggleNewPassword()"><i class="fa-solid fa-eye-slash eye-slash1 eye-fa-fa curs"></i></span>

                                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />

                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-12 m-0">
                                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                            <x-text-input id="confirm_password" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                            <span class="toggle-password" style="cursor: pointer; position: absolute; right: 20px; top: 40px;" onclick="toggleConfirmPassword()">
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </span>
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />

                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-divider">Your Home</div> --}}

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                            <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg btn-block">Register</button>
                                    </div>
                                </form>

                                <div class="flex items-center justify-end mt-4">
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ url('/') }}">
                                        {{ __('Already registered?') }}
                                    </a>

                                    {{-- <x-primary-button class="ms-4">
                                        {{ __('Register') }}
                                    </x-primary-button> --}}
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            {{-- Copyright &copy; CodiePie 2020 --}}
                            © Copyright All Rights Reserved. Design: [PNAC]
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="assets/bundles/lib.vendor.bundle.js"></script>
    <script src="js/CodiePie.js"></script>

    <!-- JS Libraies -->
    <script src="assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="js/page/auth-register.js"></script>

    <!-- Template JS File -->
    <script src="js/scripts.js"></script>
    <script src="js/custom.js"></script>


    <script>

        function toggleNewPassword() {
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

        function toggleConfirmPassword() {
    const confirmField = document.getElementById('confirm_password');
    const icon = confirmField.nextElementSibling.querySelector('i');

    if (confirmField.type === 'password') {
        confirmField.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        confirmField.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}

    </script>



</body>

<!-- auth-register.html  Tue, 07 Jan 2020 03:39:48 GMT -->
</html>
