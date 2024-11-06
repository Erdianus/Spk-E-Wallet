@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Dashboard
@endsection
@section('content')
    <div class="row justify-content-start mt-4 mb-5">
        <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title fs-4">Data Alternatif</h5>
                    <h2 class="card-text mx-2 my-3">{{ $totalAlternatives }}</h2>
                    <a href="{{ route('alternatif.index') }}" class="btn btn-light">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title fs-4">Kriteria</h5>
                    <h2 class="card-text mx-2 my-3">{{ $totalCriterias }}</h2>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-light">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title fs-4">Responden</h5>
                    <h2 class="card-text mx-2 my-3">{{ $totalRespondens }}</h2>
                    <a href="{{ route('responden.index') }}" class="btn btn-light">Lihat Data</a>
                </div>
            </div>
        </div>
    </div>
@endsection
