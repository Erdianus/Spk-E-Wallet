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
                        <td>
                            @foreach ($weights as $weight)
                                @if ($weight->criteria_id == $criteria->id)
                                    {{ $weight->weight }}
                                @endif
                            @endforeach
                        </td>
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
                {{-- @php
                    $matrixKeputusan = [];
                @endphp --}}
                @foreach ($alternatives as $row => $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                        @foreach ($alternative->criteria as $column => $value)
                            <td>{{ $value->criteria_value->value }}</td>
                            {{-- @php
                                $matrixKeputusan[$column][$row] = $value->criteria_value->value;
                            @endphp --}}
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
                {{-- @php
                    $matrixKeputusanNormalisasi = [];
                @endphp --}}
                @foreach ($alternatives as $row => $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                        @foreach ($alternative->criteria as $column => $value)
                            {{-- @php
                                $maxValue = max($matrixKeputusan[$column]);
                                $minValue = max($matrixKeputusan[$column]);
                                if ($value->type_of_criteria == 'Benefit') {
                                    $result = $value->criteria_value->value / $maxValue;
                                } elseif ($value->type_of_criteria == 'Cost') {
                                    $result = $minValue / $value->criteria_value->value;
                                }
                                $matrixKeputusanNormalisasi[$column][$row] = $result;
                            @endphp --}}
                            <td>{{ $matrixKeputusanNormalisasi[$column][$row] }}</td>
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
                {{-- @php
                        $qiValue = [];
                        foreach ($alternatives as $row => $alternative) {
                            $perkalian = [];
                            $perpangkatan = [];
                            foreach ($criterias as $column => $criteria) {
                                $perkalian[$column] =
                                    $matrixKeputusanNormalisasi[$column][$row] * $criteria->weight->weight;
                                $perpangkatan[$column] =
                                    $matrixKeputusanNormalisasi[$column][$row] ^ $criteria->weight->weight;
                            }
                            $totalRowPerkalian = array_sum($perkalian);
                            $totalRowPerpangkatan = array_sum($perpangkatan);
                            $qiValue[$row] = 0.5 * $totalRowPerkalian + 0.5 * $totalRowPerpangkatan;
                        }
                    @endphp --}}
                @foreach ($alternatives as $row => $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                        <td>{{ $qiValue[$row] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Hasil Perangkingan Metode WASPAS --}}
    <div class="card p-3 my-2">
        <div class="card-header pt-3">
            <h4>Hasil Akhir Perangkingan</h4>
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
                {{-- @php
                        $qiValue = [];
                        foreach ($alternatives as $row => $alternative) {
                            $perkalian = [];
                            $perpangkatan = [];
                            foreach ($criterias as $column => $criteria) {
                                $perkalian[$column] =
                                    $matrixKeputusanNormalisasi[$column][$row] * $criteria->weight->weight;
                                $perpangkatan[$column] =
                                    $matrixKeputusanNormalisasi[$column][$row] ^ $criteria->weight->weight;
                            }
                            $totalRowPerkalian = array_sum($perkalian);
                            $totalRowPerpangkatan = array_sum($perpangkatan);
                            $qiValue[$row] = 0.5 * $totalRowPerkalian + 0.5 * $totalRowPerpangkatan;
                        }
                    @endphp --}}
                @foreach ($hasilPerangkingan as $value)
                    {{-- {{ dd($value['name']) }} --}}
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['qi'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
