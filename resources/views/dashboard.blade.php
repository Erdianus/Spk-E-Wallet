@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Dashboard
@endsection
@section('content')
    <div class="row justify-content-start mt-4 mb-5">
        <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Alternatif</h5>
                    <p class="card-text">(Total data alternatif)</p>
                    <a href="{{ route('alternatif.index') }}" class="btn btn-primary">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kriteria</h5>
                    <p class="card-text">(Total data kriteria)</p>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-primary">Lihat Data</a>
                </div>
            </div>
        </div>
    </div>
@endsection
