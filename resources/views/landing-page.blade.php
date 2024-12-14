@extends('users-page.layouts')
@section('title')
    SPK E-Wallet Metode AHP-WASPAS
@endsection
@section('alert')
    @if (session('error'))
        <div class="my-3 alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endsection
@section('header-title')
    Perbandingan Kriteria SPK E-Wallet
@endsection
@section('description')
    <div class="row">
        <span class="badge bg-warning text-dark">
            <h5>Silahkan input nilai perbandingan anda berdasarkan kriteria yan
                tersedia dibawah ini!</h5>
        </span>
    </div>
@endsection
@section('content')
    {{-- Input Perbandingan --}}
    <div class="row my-3">
        <div class="card p-2">
            <form id="form-respondent" action="{{ route('nilai-perbandingan') }}" method="POST">
                @csrf
                <div class="mt-2 mx-3">
                    <input class="form-control" type="text" name="responden" id="responden" placeholder="Nama Responden"
                        required>
                </div>
                <div class="p-3 table-responsive d-flex justify-content-center">
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
                                                                value="{{ 'for-' . $criteria->code . '-' . $i }}" required>
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
                                                                {{ $nilaiPerbandingan == null ? 'checked' : '' }} required>
                                                        @endif
                                                    @else
                                                        <input type="radio"
                                                            name="{{ $criteria->code . '/' . $criteria2->code }}"
                                                            value="1"
                                                            {{ $nilaiPerbandingan == null ? 'checked' : '' }} required>
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
                                                                value="{{ 'for-' . $criteria->code . '-' . $i }}" required>
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
                    <a href="{{ route('perbandingan-page') }}" class="btn btn-primary" type="button">Reload</a>
                </div>
            </form>
        </div>
    </div>
@endsection
</div>
