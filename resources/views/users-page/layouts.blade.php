<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/webp" href="{{ asset('img/e-wallet.webp') }}">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('head')
    <title>@yield('title')</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1d4ed8;
            --accent-color: #3b82f6;
            --light-bg: #f0f9ff;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', sans-serif;
        }
    </style>
    @yield('style')
</head>

<body>
    <div class="sticky-top">
        @include('users-page.navbar')
    </div>
    <div class="container my-5">
        @include('users-page.modal-help')
        <div class="d-flex justify-content-center">
            @include('users-page.e-wallet')
        </div>
        <div class="row">
            <div class="text-center mb-5">
                <h2>@yield('header-title')</h2>
            </div>
        </div>
        @yield('alert')
        @yield('description')
        <div class="row mt-3">
            @yield('content')
        </div>
        <button id="helpButton" type="button"
            class="btn btn-primary position-fixed bottom-0 end-0 m-4 p-1 rounded-circle shadow" data-bs-toggle="modal"
            data-bs-target="#helpModal">
            Help?
        </button>

        @include('layouts.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</body>

</html>
