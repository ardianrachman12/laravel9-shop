<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Page Meta Tags-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <!-- Custom Google Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600&family=Roboto:wght@300;400;700&display=auto"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('bundle1/assets/images/spirit-small.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('bundle1/assets/images/spirit-small.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('bundle1/assets/images/spirit-small.png') }}">
    <link rel="mask-icon" href="{{ asset('bundle1/assets/images/spirit-small.png') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('bundle1/assets/css/libs.bundle.css') }}" />

    <!-- Main CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('sbadmin2/vendor/bootstrap/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('bundle1/assets/css/theme.bundle.css') }}" />

    <noscript>
        <style>
            /**
              * Reinstate scrolling for non-JS clients
              */
            .simplebar-content-wrapper {
                overflow: auto;
            }
        </style>
    </noscript>
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

    <title>E-commerce | SPIRIT</title>
</head>

<body>
    @include('layouts.home.navbar')
    <div class="mt-10">
        @yield('content')
    </div>
    @include('layouts.home.footer')

    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- jQuery dan Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script> --}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Theme JS -->
    <!-- Vendor JS -->
    <script src="{{ asset('bundle1/assets/js/vendor.bundle.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('bundle1/assets/js/theme.bundle.js') }}"></script>

    @stack('script')
</body>

</html>
