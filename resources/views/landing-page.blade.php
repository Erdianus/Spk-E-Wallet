<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SPK E-Wallet Metode AHP-WASPAS</title>
</head>

<body>
    <div class="sticky-top">
        <nav class="navbar bg-success p-0">
            <div class="container-fluid">
                <a class="navbar-brand text-white py-3 px-4" href="">SPK E-Wallet</a>
                <ul class="flex-row list-inline mb-0">
                    <li class="nav-item list-inline-item text-nowrap d-md-none">
                        <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <svg class="bi">
                                <use xlink:href="#list" />
                            </svg>
                        </button>
                    </li>
                    <li class="nav-item list-inline-item dropdown">
                        <a href="{{ route('form-login') }}" class="nav-link px-3 text-white">
                            Login
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                                <path fill-rule="evenodd"
                                    d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container my-5">
        <div class="d-flex justify-content-center">
            <img class="mx-1" src="{{ asset('img/Dana.png') }}" width="150" style="object-fit:contain">
            <img class="mx-1" src="{{ asset('img/Doku.png') }}" width="50" style="object-fit:contain">
            <img class="mx-1" src="{{ asset('img/gopay.png') }}" width="150" style="object-fit:contain">
            <img class="" src="{{ asset('img/ShopeePay.png') }}" width="150" style="object-fit:contain">
            <img class="mx-1" src="{{ asset('img/Ovo.png') }}" width="150" style="object-fit:contain">
            <img class="mx-1" src="{{ asset('img/Link Aja.png') }}" width="150" style="object-fit:contain">
            <img class="mx-1" src="{{ asset('img/I-Saku.png') }}" width="150" style="object-fit:contain">
        </div>
        <div class="row">
            <div class="text-center mb-5">
                <h2>Welcome to SPK E-Wallet</h2>
            </div>
        </div>
        <div class="row">
            <span class="badge bg-warning text-dark">Silahkan input nilai perbandingan anda berdasarkan kriteria yan
                tersedia dibawah ini!</span>
        </div>
        {{-- Input Perbandingan --}}
        <div class="row">
            <div class="card">
                <form id="form-respondent" action="{{ route('landing-page') }}" method="get">
                    <div class="p-3 table-responsive p-2 d-flex justify-content-center">
                        <table class="table table-bordered text-center">

                            <thead>
                                <tr>
                                    <th rowspan="2" class="col align-middle">Nama Kriteria</th>
                                    <th colspan="17" class="col align-middle">Nilai Perbandingan</th>
                                    <th rowspan="2" class="col align-middle">Nama Kriteria</th>
                                </tr>
                                <tr>
                                    @for ($i = 9; $i > 0; $i--)
                                        <th>{{ $i }}</th>
                                    @endfor
                                    @for ($i = 2; $i <= 9; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $check = [];
                                @endphp
                                @foreach ($criterias as $criteria)
                                    @foreach ($criterias as $criteria2)
                                        @if ($criteria->code == $criteria2->code)
                                            <input type="hidden" name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                value="1">
                                        @endif
                                        @if ($criteria->name != $criteria2->name)
                                            @if (!array_key_exists($criteria->name . '-' . $criteria2->name, $check))
                                                <tr>
                                                    <th>{{ $criteria->name }}</th>
                                                    @for ($i = 9; $i >= 2; $i--)
                                                        <td>
                                                            @if ($nilaiPerbandingan)
                                                                @if (array_key_exists($criteria->code . '/' . $criteria2->code, $nilaiPerbandingan))
                                                                    <input type="radio"
                                                                        name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                        value="{{ 'for-' . $criteria->code . '-' . $i }}"
                                                                        {{ $nilaiPerbandingan[$criteria->code . '/' . $criteria2->code] == 'for-' . $criteria->code . '-' . $i ? 'checked' : '' }}
                                                                        required>
                                                                @else
                                                                    <input type="radio"
                                                                        name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                        value="{{ 'for-' . $criteria->code . '-' . $i }}"
                                                                        required>
                                                                @endif
                                                            @else
                                                                <input type="radio"
                                                                    name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                    value="{{ 'for-' . $criteria->code . '-' . $i }}"
                                                                    required>
                                                            @endif
                                                        </td>
                                                    @endfor
                                                    <td>
                                                        @if ($nilaiPerbandingan)
                                                            @if (array_key_exists($criteria->code . '/' . $criteria2->code, $nilaiPerbandingan))
                                                                <input type="radio"
                                                                    name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                    value="1"
                                                                    {{ $nilaiPerbandingan[$criteria->code . '/' . $criteria2->code] == 1 ? 'checked' : '' }}
                                                                    required>
                                                            @else
                                                                <input type="radio"
                                                                    name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                    value="1"
                                                                    {{ $nilaiPerbandingan == null ? 'checked' : '' }}
                                                                    required>
                                                            @endif
                                                        @else
                                                            <input type="radio"
                                                                name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                value="1"
                                                                {{ $nilaiPerbandingan == null ? 'checked' : '' }}
                                                                required>
                                                        @endif
                                                    </td>
                                                    @for ($i = 2; $i <= 9; $i++)
                                                        <td>
                                                            @if ($nilaiPerbandingan)
                                                                @if (array_key_exists($criteria->code . '/' . $criteria2->code, $nilaiPerbandingan))
                                                                    <input type="radio"
                                                                        name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                        value="{{ 'for-' . $criteria2->code . '-' . $i }}"
                                                                        {{ $nilaiPerbandingan[$criteria->code . '/' . $criteria2->code] == 'for-' . $criteria2->code . '-' . $i ? 'checked' : '' }}
                                                                        required>
                                                                @else
                                                                    <input type="radio"
                                                                        name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                        value="{{ 'for-' . $criteria2->code . '-' . $i }}"
                                                                        required>
                                                                @endif
                                                            @else
                                                                <input type="radio"
                                                                    name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                                    value="{{ 'for-' . $criteria->code . '-' . $i }}"
                                                                    required>
                                                            @endif
                                                        </td>
                                                    @endfor
                                                    <th>{{ $criteria2->name }}</th>
                                                </tr>
                                                @php
                                                    $check[$criteria->name . '-' . $criteria2->name] = true;
                                                    $check[$criteria2->name . '-' . $criteria->name] = true;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-2 mb-5">
                        <button class="btn btn-success" type="submit">Lihat Hasil</button>
                        <a href="{{ route('landing-page') }}" class="btn btn-primary" type="button">Reload</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Hasil Perhitungan --}}
        @if (!empty($hasilPerangkingan))
            <div id="hasil-perangkingan" class="row pt-3">
                <div class="card p-3">
                    <div class="card-header text-center pt-3">
                        <h4>Hasil Perangkingan</h4>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="col">No</th>
                                <th class="col">Nama Alternatif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilPerangkingan as $alternative)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alternative['name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @include('layouts.footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (!empty($failed))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error', // Change to 'success', 'info', or 'warning' based on your message type
                    title: 'Oops...',
                    text: '{{ $failed }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @elseif(!empty($success))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success', // Change to 'success', 'info', or 'warning' based on your message type
                    title: 'yesss',
                    text: '{{ $success }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

</html>
