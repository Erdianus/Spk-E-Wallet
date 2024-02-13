@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Alternatif
@endsection
@section('content')
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
