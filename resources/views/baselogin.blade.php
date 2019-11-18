<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- For Google -->
    <link rel="author" href="https://plus.google.com/+Scoopthemes">
    <link rel="publisher" href="https://plus.google.com/+Scoopthemes">

    <!-- Canonical -->
    <link rel="canonical" href="">

    <title>Support App</title>

    <!-- Bootstrap-->
     <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/BS/css/bootstrap.min.css') }} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/mdi/css/mdi.css') }} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/SA/ubay.css') }} ">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/dtable/datatables.css') }} ">

        <!-- JS -->
        <script type="text/javascript" src="{{ asset('assets/BS/js/jquery.min.js') }} "></script>
        <script type="text/javascript" src="{{ asset('assets/BS/js/popper.min.js') }} "></script>
        <script type="text/javascript" src="{{ asset('assets/BS/js/bootstrap.min.js') }} "></script>
        <script type="text/javascript" src="{{ asset('assets/SA/sweetalert-dev.js') }} "></script>
        <script type="text/javascript" src="{{ asset('assets/dtable/datatables.js') }} "></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> --}}

    {{-- end --}}

        <!-- Main Styles CSS -->
        <style>
            html{
                padding: 0;
                margin: 0;
                background-image: url('http://localhost:8000/assets/img/login-bg.jpg');
            }
            body{
                background: transparent;
            }
            .bg-form-login{
                margin: 120px auto;
                width: 30em;
                background: rgba(240,240,240, .6);
                padding: 20px;
                box-shadow: 0px 3px 6px #b9b9b9;
                border-radius: 10px;
            }

        </style>

</head>

<body>

<div>

    @yield('content') {{-- Semua file konten kita akan ada di bagian ini --}}

</div>

</body>

</html>
