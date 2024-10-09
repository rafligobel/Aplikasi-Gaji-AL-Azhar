<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page" style="center fixed">
{{-- style="margin: 0; height: 100%; background: url('{{ asset('images/bg.jpg') }}') no-repeat center center fixed; background-size: cover;">> --}}
<div class="login-box center">
    <div class="container ">
        <div class="row justify-content-center">
    <div class="text-center">
        <!-- Logo Section -->
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Al-Azhar" class="img-fluid" style="max-width: 75px;">
        </div>
        <!-- Text Below Logo -->
        <div class="center">
            <h3>Aplikasi Gaji</h3>
            <p> Sekolah KB TK SD Al-Azhar 43 Gorontalo</p>
        </div>
    </div>
    <!-- /.login-logo -->
    <div class="card center">
        @yield('content')
    </div>
</div>
<!-- /.login-box -->

@vite('resources/js/app.js')
<!-- Bootstrap 4 -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}" defer></script>
</body>
</html>
