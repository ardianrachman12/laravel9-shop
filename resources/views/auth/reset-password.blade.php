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
                                        <h1 class="h4 text-gray-900 mb-2">Create New Password</h1>
                                        <p class="mb-4">Silahkan buat password baru!</p>
                                    </div>
                                    <form action="{{ route('password.update') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="email" value="{{ request()->email }}">
                                            <input type="hidden" name="token" value="{{ request()->token }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                placeholder="Enter New Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password_confirmation" placeholder="Enter Password Confirmation"
                                                name="password_confirmation">
                                        </div>
                                        <button type="submit"class="btn btn-primary btn-user btn-block">Create New
                                            Password</button>
                                    </form>
                                    {{-- <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('auth.register') }}">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('auth.login') }}">Already have an account?
                                            Login!</a>
                                    </div> --}}
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
