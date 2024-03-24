@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Kriteria
@endsection
@section('content')
    {{-- Perbandingan Data Antar Kriteria --}}
    <div class="card my-2">
        <div class="card-header">
            <h3>Perbandingan Data Antar Kriteria</h3>
        </div>
        <form action="{{ route('pembobotan.kriteria') }}" method="get">
            <div class="table-responsive p-3 d-flex justify-content-center">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2" class="col p-2 text-end align-middle">Nama Kriteria</th>
                            <th colspan="17" class="col p-2 text-center align-middle">Skala Perbandingan</th>
                            <th rowspan="2" class="col p-2 text-start align-middle">Nama Kriteria</th>
                        </tr>
                        <tr>
                            @php
                                $start = 9;
                                $end = 1;
                                for ($i = $start; $i >= $end; $i--) {
                                    echo "<th class='col p-2 text-center'>$i</th>";
                                }
                                for ($i = 2; $i <= $start; $i++) {
                                    echo "<th class='col p-2 text-center'>$i</th>";
                                }
                            @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $check = [];
                        @endphp
                        @foreach ($criterias as $criteria)
                            @foreach ($criterias2 as $criteria2)
                                @if ($criteria->name != $criteria2->name)
                                    @if (!array_key_exists($criteria->name . '-' . $criteria2->name, $check))
                                        <tr>
                                            @php
                                                $name = $criteria->name . '-' . $criteria2->name;
                                            @endphp
                                            <td class="p-2 text-end">
                                                {{ $criteria->name }}
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight" checked>
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-center">
                                                <input class="m-2" type="radio" name="{{ $name }}"
                                                    id="weight">
                                            </td>
                                            <td class="p-2 text-start">
                                                {{ $criteria2->name }}
                                            </td>
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
            <div class="pb-3 pt-0 d-flex justify-content-center">
                <button type="submit" class="mx-2 btn btn-warning">Cek Konsistensi</button>
                <a href="#" type="button" class="mx-2 btn btn-success">Simpan</a>
                <a href="#" type="button" class="mx-2 btn btn-danger">Reset</a>
            </div>
        </form>
    </div>
    {{-- Matriks Perbandingan Berpasangan --}}
    <div class="card mt-4">
        <div class="pt-3 card-header">
            <h5>Matriks Perbandingan Berpasangan</h5>
        </div>
        <div class="p-3 table-responsive p-2 d-flex justify-content-center">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <td class="col"></td>
                        @foreach ($criterias as $criteria)
                            <td class="col">{{ $criteria->code }}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $criteria)
                        <tr>
                            <td>{{ $criteria->code }}</td>
                            @foreach ($criterias2 as $criteria)
                                <td></td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <th>Jumlah</th>
                        @foreach ($criterias as $criteria)
                            <th></th>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{-- Matriks Nilai Kriteria (Normalisasi) --}}
    <div class="card mt-4">
        <div class="pt-3 card-header">
            <h5>Matriks Nilai Kriteria (Normalisasi)</h5>
        </div>
        <div class="p-3 table-responsive p-2 d-flex justify-content-center">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <td class="col"></td>
                        @foreach ($criterias as $criteria)
                            <td class="col">{{ $criteria->code }}</td>
                        @endforeach
                        <th class="col">Jumlah</th>
                        <th class="col">Prioritas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $criteria)
                        <tr>
                            <td>{{ $criteria->code }}</td>
                            @foreach ($criterias2 as $criteria)
                                <td></td>
                            @endforeach
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Matriks Penjumlahan Tiap Baris --}}
    <div class="card mt-4">
        <div class="pt-3 card-header">
            <h5>Matriks Penjumlahan Tiap Baris</h5>
        </div>
        <div class="p-3 table-responsive d-flex justify-content-center">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <td class="col"></td>
                        @foreach ($criterias as $criteria)
                            <td class="col">{{ $criteria->code }}</td>
                        @endforeach
                        <td class="col">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $criteria)
                        <tr>
                            <td>{{ $criteria->code }}</td>
                            @foreach ($criterias2 as $criteria)
                                <td></td>
                            @endforeach
                            <td>total pemjumlahan tiap baris</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Perhitungan Konsistensi Rasio --}}
    <div class="card mt-4">
        <div class="pt-3 card-header">
            <h5>Perhitungan Konsistensi Rasio</h5>
        </div>
        <div class="table-responsive p-3 d-flex justify-content-center">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <td scope="col"></td>
                        <td scope="col">Jumlah per Baris</td>
                        <td scope="col">Prioritas</td>
                        <td scope="col">Hasil</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($criterias as $criteria)
                        <tr>
                            <td>{{ $criteria->code }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pt-3 px-3 d-flex justify-content-center table-responsive">
            <table class="table">
                <tr>
                    <th class="col">Jumlah</th>
                    <td class="col">=</td>
                    <td class="col"></td>
                </tr>
                <tr>
                    <th class="col">n</th>
                    <td class="col">=</td>
                    <td class="col"></td>
                </tr>
                <tr>
                    <th class="col">λ maks</th>
                    <td class="col">=</td>
                    <td class="col"></td>
                </tr>
                <tr>
                    <th class="col">CI</th>
                    <td class="col">=</td>
                    <td class="col"></td>
                </tr>
                <tr>
                    <th class="col">CR</th>
                    <td class="col">=</td>
                    <td class="col"></td>
                </tr>
                <tr>
                    <th class="col"> CR<=0.1 </th>
                    <td class="col">=</td>
                    <td class="col">Konsistensi or not</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
