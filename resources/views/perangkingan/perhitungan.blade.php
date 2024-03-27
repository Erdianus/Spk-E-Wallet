@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Perhitungan
@endsection
@section('content')
    {{-- Bobot Kriteria --}}
    <div class="card p-3 my-2">
        <div class="card-header pt-3">
            <h4>Bobot Kriteria (W)</h4>
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr class="table-primary">
                    @foreach ($criterias as $criteria)
                        <th class="col">{{ $criteria->code }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($criterias as $criteria)
                        <td>{{ $loop->iteration }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Matriks Keputusan (X) --}}
    <div class="card p-3 my-2">
        <div class="card-header pt-3">
            <h4>Matrix Keputusan (X)</h4>
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr class="table-primary">
                    <th class="col">No</th>
                    <th class="col">Alternatif</th>
                    @foreach ($criterias as $criteria)
                        <th class="col">{{ $criteria->code }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatives as $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                        {{-- {{ dd($alternative->criteria) }} --}}
                        @foreach ($alternative->criteria as $value)
                            <td>{{ $value->criteria_value->value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Matriks Normalisasi (R) --}}
    <div class="card p-3 my-2">
        <div class="card-header pt-3">
            <h4>Matrix Normalisasi (R)</h4>
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr class="table-primary">
                    <th class="col">No</th>
                    <th class="col">Alternatif</th>
                    @foreach ($criterias as $criteria)
                        <th class="col">{{ $criteria->code }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatives as $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                        {{-- {{ dd($alternative->criteria) }} --}}
                        @foreach ($alternative->criteria as $value)
                            <td>{{ $value->criteria_value->value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Perhitungan Nilai Qi --}}
    <div class="card p-3 my-2">
        <div class="card-header pt-3">
            <h4>Perhitungan Nilai Qi</h4>
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr class="table-primary">
                    <th class="col">No</th>
                    <th class="col">Alternatif</th>
                    <th class="col">Nilai Qi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatives as $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                        {{-- {{ dd($alternative->criteria) }} --}}
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
