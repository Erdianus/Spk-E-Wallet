@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('style')
    <style>
        /* Customize sidebar width */
        .sidebar {
            min-width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background-color: #343a40;
            padding-top: 60px;
            /* Adjust according to your needs */
        }

        /* Sidebar links */
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            color: #ffffff;
            display: block;
            transition: all 0.3s;
        }

        /* Sidebar links on hover */
        .sidebar a:hover {
            background-color: #454d55;
        }

        /* Responsive styles */
        @media (max-width: 991.98px) {
            .sidebar {
                width: 250px;
                left: -250px;
                transition: all 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .toggle-sidebar {
                display: block;
            }
        }

        @media (min-width: 992px) {
            .toggle-sidebar {
                display: none;
            }
        }
    </style>
@endsection
@section('page')
    Dashboard
@endsection
@section('content-page')
    <div class="row justify-content-start mt-4 mb-5">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Alternatif</h5>
                    <p class="card-text">(Total data alternatif)</p>
                    <a href="{{ route('alternatif.index') }}" class="btn btn-primary">Lihat Data</a>
                </div>
            </div>
        </div>
        <div class="col-3">
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
