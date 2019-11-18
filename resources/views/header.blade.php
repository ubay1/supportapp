<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    {{-- end --}}

</head>

<body>

<div class="maincontainer">
    <div id="header">
        <div id="icon-hamburger">
            <div id="nav1"></div>
            <div id="nav2"></div>
            <div id="nav3"></div>
        </div>

        <a href="{{ url('admin/') }}" class="logo"><span>Support App <i class="mdi mdi-clipboard-check"></i></span></a>

        <a class="bg_logout" href="{{ url('admin/logout') }}"><span class="mdi mdi-power mdi-24px"></span></a>
    </div>

    <div id="drawer">
        <div id="bg-img-drawer">
            <img src="{{ asset('assets/img/bgdrawer.png') }}" alt="" id="img-drawer">
            <div class="bg-fotouser">
                <img src="{{ asset('assets/img/team1.jpg') }}" alt="" id="fotouser">
            </div>
            <span id="txt_nama">{{Session::get('jabatan')}},  ({{Session::get('nama')}})</span>
        </div>

        @if(\Session::get('jabatan') == 'superadmin')
            <a href="{{ url('admin/kelolaTS') }}"><span class="mdi mdi-account-settings-variant mdi-24px icon_listmenu"></span> Kelola Teknikal Support</a>
            <a href="{{ url('admin/kelolaProject') }}"><span class="mdi mdi-checkbox-multiple-marked-circle mdi-24px icon_listmenu"></span> Kelola Project </a>
        @endif
        @if(\Session::get('jabatan') != 'superadmin')
            <a href="{{ url('admin/kelolaTeknisi') }}"><span class="mdi mdi-account-multiple-plus mdi-24px icon_listmenu"></span> Kelola Teknisi </a>
            <a href="{{ url('admin/kelolaProject') }}"><span class="mdi mdi-checkbox-multiple-marked-circle mdi-24px icon_listmenu"></span> Kelola Project </a>
            <a href="{{ url('admin/kelolaMasalah') }}"><span class="mdi mdi-comment-check mdi-24px icon_listmenu"></span> Kelola Masalah Project </a>
        @endif

    </div>

    @yield('content')
</div>

</body>

</html>
