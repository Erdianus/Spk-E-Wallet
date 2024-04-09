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
        <form action="{{ route('pembobotan.input-skala') }}" method="POST">
            @csrf
            <div class="p-3 d-flex justify-content-center">
                <select class="form-select m-2" name="skala" id="skala" required>
                    <option value="">---Pilih Perbandingan Kriteria---</option>
                    @php
                        $check = [];
                    @endphp
                    @foreach ($criterias as $criteria)
                        @foreach ($criterias2 as $criteria2)
                            @if ($criteria->name != $criteria2->name)
                                @if (!array_key_exists($criteria->name . '-' . $criteria2->name, $check))
                                    <option value="{{ $criteria->id . '/' . $criteria2->id }}">
                                        {{ $criteria->name . '(' . $criteria->code . ')' . ' / ' . $criteria2->name . '(' . $criteria2->code . ')' }}
                                    </option>
                                    @php
                                        $check[$criteria->name . '-' . $criteria2->name] = true;
                                        $check[$criteria2->name . '-' . $criteria->name] = true;
                                    @endphp
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </select>
                <select class="form-select m-2" name="for" id="for" disabled required>
                    <option value="">---Pilih Criteria---</option>
                </select>
                <select class="form-select m-2" name="value" id="value" disabled required>
                    <option value="">---Nilai Perbandingan---</option>
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary m-2">Input </button>
            </div>
        </form>
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
                    @php
                        $tablePerbandingan = [];
                    @endphp
                    @foreach ($criterias as $row => $criteria1)
                        <tr>
                            <td>{{ $criteria1->code }}</td>
                            @foreach ($criterias2 as $column => $criteria2)
                                @php
                                    $result = null;
                                @endphp
                                <td>
                                    @foreach ($perbandingan_kriteria as $data)
                                        @if ($data->criteria1_id == $criteria1->id && $data->criteria2_id == $criteria2->id)
                                            @if ($data->for_criteria == $criteria1->id)
                                                @php
                                                    $result = $data->weight;
                                                @endphp
                                            @else
                                                @php
                                                    $result = 1 / $data->weight;
                                                @endphp
                                            @endif
                                        @elseif($data->criteria1_id == $criteria2->id && $data->criteria2_id == $criteria1->id)
                                            @if ($data->for_criteria == $criteria1->id)
                                                @php
                                                    $result = $data->weight;
                                                @endphp
                                            @else
                                                @php
                                                    $result = 1 / $data->weight;
                                                @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    {{ !is_float($result) ? $result : number_format($result, 5) }}
                                </td>
                                @php
                                    $tablePerbandingan[$column][$row] = $result;
                                @endphp
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <th>Jumlah</th>
                        @php
                            $totalColumnPerbandingan = [];
                            foreach ($tablePerbandingan as $keyColumn => $column) {
                                $jumlah = 0;
                                foreach ($column as $keyRow => $row) {
                                    $jumlah += $row;
                                }
                                $totalColumnPerbandingan[$keyColumn] = $jumlah;
                                echo '<th>' . number_format($jumlah, 5) . '</th>';
                            }
                        @endphp
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- --------- Matriks Perbandingan Normasilasi --------- --}}
    <form id="save-weight" action="{{ route('pembobotan.store') }}" method="POST">
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
                            <th>Jumlah</th>
                            <th>Prioritas / Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tableNormalisasi = [];
                            $totalRowNormalisasi = [];
                        @endphp
                        @foreach ($criterias as $row => $criteria1)
                            <tr>
                                <td>{{ $criteria1->code }}</td>
                                @php
                                    $jumlah = 0;
                                @endphp
                                @foreach ($criterias2 as $column => $criteria2)
                                    @php
                                        $result = null;
                                    @endphp
                                    <td>
                                        @foreach ($perbandingan_kriteria as $data)
                                            @if ($data->criteria1_id == $criteria1->id && $data->criteria2_id == $criteria2->id)
                                                @if ($data->for_criteria == $criteria1->id)
                                                    @php
                                                        $result = $data->weight;
                                                    @endphp
                                                @else
                                                    @php
                                                        $result = 1 / $data->weight;
                                                    @endphp
                                                @endif
                                            @elseif($data->criteria1_id == $criteria2->id && $data->criteria2_id == $criteria1->id)
                                                @if ($data->for_criteria == $criteria1->id)
                                                    @php
                                                        $result = $data->weight;
                                                    @endphp
                                                @else
                                                    @php
                                                        $result = 1 / $data->weight;
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach
                                        @php
                                            $hasilNormalisasi = $result / $totalColumnPerbandingan[$column];
                                            $jumlah += $hasilNormalisasi;
                                            echo number_format($hasilNormalisasi, 5);
                                        @endphp
                                    </td>
                                    {{-- @php
                                        $tableNormalisasi[$column][$row] = $hasilNormalisasi;
                                    @endphp --}}
                                @endforeach
                                @php
                                    $totalRowNormalisasi[$row] = $jumlah;
                                @endphp
                                <th>{{ number_format($jumlah, 5) }}</th>
                                <th>{{ number_format($jumlah / $criteria2->count(), 5) }}</th>
                            </tr>
                            <input type="hidden" name="{{ $criteria1->code }}"
                                value="{{ $criteria1->id . '-' . number_format($jumlah / $criteria2->count(), 5) }}">
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="mx-2 btn btn-primary">Simpan</button>
            <button type="button" class="mx-2 btn btn-warning">Check Konsistensi</button>
        </div>
    </form>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#skala').change(function(e) {
                var skala = $(this).val();
                var criteria_id1 = skala.split('/')[0];
                var criteria_id2 = skala.split('/')[1];
                var criterias = {!! json_encode($criterias) !!};
                const criteria1 = criterias.find(e => e.id == criteria_id1);
                const criteria2 = criterias.find(e => e.id == criteria_id2);
                $('#for').empty();
                $('#for').append(`<option value="">---Pilih Criteria---</option>`);
                $('#for').append(
                    `<option value="${criteria1.id}">${criteria1.name}(${criteria1.code})</option>`);
                $('#for').append(
                    `<option value="${criteria2.id}">${criteria2.name}(${criteria2.code})</option>`);
                // console.log(criteria1);
                // console.log(criteria2);
                if (skala) {
                    $('#for').prop('disabled', false);
                    $('#value').prop('disabled', false);
                } else {
                    $('#for').prop('disabled', true);
                    $('#value').prop('disabled', true);
                }
            })
        })
        // // --------------------Input Matriks Perbandingan-----------------------
        $('#save-weight').on('submit', function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            console.log(data);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                dataType: 'JSON',
                data: data,
                success: function(res) {
                    if (res.status == true) {
                        Swal.fire({
                            title: "Saved!",
                            text: "Bobot Berhasil Disimpan",
                            icon: "success"
                        }).then((result) => {
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
