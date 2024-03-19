@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Kriteria
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            Pembobotan Menggunakan Metode AHP
        </div>
        <h3>Perbandingan Data Antar Kriteria</h3>
        <form action="{{ route('pembobotan.kriteria') }}" method="get"></form>
        <div class="table-responsive p-2">
            <table class="table text-start mb-0">
                <tr>
                    <th>Kriteria</th>
                    <th>Skala Perbandingan</th>
                    <th>Kriteria</th>
                </tr>
                
            </table>
        </div>
    </div>
@endsection
