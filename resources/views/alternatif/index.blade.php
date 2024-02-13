@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Alternatif
@endsection
@section('page')
    Data Alternatif
@endsection
@section('addition-css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" rel="stylesheet">
@endsection
@section('content-page')
    <div class="card">
        <div class="card-header py-3">
            <h6>Data Alternatif E-Wallet</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center mb-0" id="table">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Project</th>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Budget</th>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Status</th>
                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">Completion</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('additional-js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
