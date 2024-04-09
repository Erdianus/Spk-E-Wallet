@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Data Kriteria
@endsection
@section('content')
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
    <div class="mt-3 d-flex justify-content-center">
        <form id="simpan-pembobotan" action="{{ route('pembobotan.store') }}" method="POST">
            @csrf
            @foreach ($criterias as $criteria)
                <input type="hidden" name="{{ $criteria->code }}" value="{{ $criteria->code }}">
            @endforeach
            <button type="submit" class="mx-2 btn btn-success">Simpan Pembobotan</button>
        </form>
    </div>
@endsection
@section('javascript')
    <script>
        // --------------------Input Matriks Perbandingan-----------------------
        $('#matriks-perbandingan').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            //console.log(url);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: url,
                dataType: 'JSON',
                data: data,
                success: function(res) {
                    if (res.status == true) {
                        Swal.fire({
                            title: "Created!",
                            text: "Sub Kriteria has been created.",
                            icon: "success"
                        }).then((result) => {
                            $('#createForm').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Sepertinya ada kesalahan..."
                        });
                    }
                }
            })
        });
    </script>
@endsection
