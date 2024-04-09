@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Hasil Perhitungan
@endsection
@section('content')
    <div class="card p-3">
        <div class="card-header pt-3">
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
                @foreach ($alternatives as $alternative)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternative->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
