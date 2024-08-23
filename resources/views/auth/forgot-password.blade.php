<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-commerce | Forgot Password</title>

    <link rel="shortcut icon" type="image/png" sizes="16x16"
        href="{{ asset('bundle1/assets/images/spirit-small.png') }}">

    <!-- Custom fonts for this template-->
    <link href="/sbadmin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('sbadmin2/vendor/bootstrap/css/bootstrap.min.css') }}"> --}}

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7TYHKJNHWW"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7TYHKJNHWW');
    </script>
</head>

<body class="bg-gradient-info">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="mx-3">
                            @include('layouts.alert')
                        </div>
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="px-5 py-3">
                                    <div class="text-center">
                                        <a href="/">
                                            <img class="mb-2" src="{{ asset('bundle1/assets/images/spirit.png') }}"
                                                width="100px" alt="">
                                        </a>
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form action="{{ route('password.email') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address..."
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                        <button type="submit"class="btn btn-primary btn-user btn-block">Reset
                                            Password</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('auth.register') }}">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('auth.login') }}">Already have an account?
                                            Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.script')

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
    </script>

</body>

</html>
