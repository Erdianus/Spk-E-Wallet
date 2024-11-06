@extends('layouts.app')
@section('title')
    SPK-E-Wallet | Responden Hasil Perhitungan
@endsection
@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML" async></script>
    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
            tex2jax: {
                inlineMath: [
                    ['$', '$'],
                    ['\\(', '\\)']
                ],
                processEscapes: true
            },
            displayAlign: 'left',
        });
    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex justify-start">
                <a href="{{ route('responden.index') }}" class="my-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="none" viewBox="0 0 28 28">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14M5 12l4-4m-4 4 4 4" />
                    </svg>
                </a>
                <h3 class="my-2">
                    Hasil Perhitungan untuk responden {{ $responden->name }}
                </h3>
            </div>
        </div>
        <div class="mx-4">
            <div class="row my-4">
                <h1>Perhitungan menentukan Bobot Kriteria Menggunakan Metode AHP</h1>
                <p>Langkah pertama membuat table perbandingan antar kriteria berdasarkan hasil inputan yang telah
                    anda lakukan sebelumnya dengan menggunakan rumus seperti dibawah ini:</p>
                <div class=""></div>
                <p class="formula">\[
                    A = \left[ \frac{w_i}{w_j} \right] =
                    \begin{bmatrix}
                    \frac{w_1}{w_1} & \frac{w_1}{w_2} & \frac{w_1}{w_3} & \cdots & \frac{w_1}{w_n} \\
                    \frac{w_2}{w_1} & \frac{w_2}{w_2} & \frac{w_2}{w_3} & \cdots & \frac{w_2}{w_n} \\
                    \vdots & \vdots & \vdots & \ddots & \vdots \\
                    \frac{w_n}{w_1} & \frac{w_n}{w_2} & \frac{w_n}{w_3} & \cdots & \frac{w_n}{w_n}
                    \end{bmatrix}
                    \]</p>

                <h3>Keterangan:</h3>
                <p>\( w \) = nilai tingkat kepentingan</p>
                <p> Kemudian setiap elemen pada kolom di matriks perbandingan kriteria dijumlahkan terlebih dahulu:
                </p>
                <p class="formula">\[ \text{Total Kolom}_j = \sum_{i=1}^n A_{ij} \]</p>
                <h2>Tabel Perbandingan Kriteria</h2>
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">Kriteria</th>
                            @foreach ($criterias as $criteria)
                                <th scope="col">{{ $criteria->name . '(' . $criteria->code . ')' }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    @foreach ($criterias as $baris => $criteria)
                        <tr>
                            <th scope="row">{{ $criteria->name . '(' . $criteria->code . ')' }}</th>
                            @foreach ($criterias as $kolom => $criteria2)
                                <td>{{ $tablePerbandinganKriteria[$baris][$kolom] }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <th scope="row">Total</th>
                        @foreach ($criterias as $kolom => $criteria)
                            <th>{{ $totalPerKolomTablePerbandingan[$kolom] }}</th>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div class="row my-4">
                <p>Kemudian, setiap elemen pada matriks dibagi dengan jumlah total pada kolomnya untuk memperoleh
                    matriks normalisasi:</p>
                <p class="formula">\[ N_{ij} = \frac{A_{ij}}{\text{Total Kolom}_j} \]</p>
                <h2>Matriks Normalisasi Perbandingan Kriteria</h2>
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">Kriteria</th>
                            @foreach ($criterias as $criteria)
                                <th scope="col">{{ $criteria->code }}</th>
                            @endforeach
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    @foreach ($criterias as $baris => $criteria)
                        <tr>
                            <th scope="row">{{ $criteria->code }}</th>
                            @foreach ($criterias as $kolom => $criteria2)
                                <td>{{ $tableNormalisasi[$baris][$kolom] }}
                                </td>
                            @endforeach
                            <th scope="row">{{ $totalPerRowTableNormalisasi[$baris] }}</th>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        @foreach ($criterias as $kolom => $criteria)
                            <th>{{ round($totalPerKolomNormalisasiPerbandingan[$kolom]) }}</th>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div class="row my-4">
                <p>Langkah selanjutnya menghitung bobot kriteria dengan mencari rata-rata dari setiap baris di
                    matriks normalisasi:</p>
                <p class="formula">\[ \text{Bobot}_i = \frac{\sum_{j=1}^n N_{ij}}{n} \]</p>
                <h2>Tabel Bobot Kriteria</h2>
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        @foreach ($criterias as $item)
                            <th scope="col">{{ $item->code }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                    <tr>
                        @foreach ($bobotKriteria as $bobot)
                            <td scope="col">{{ $bobot }}</td>
                        @endforeach
                        <th>{{ round(collect($bobotKriteria)->sum()) }}</th>
                    </tr>
                </table>
            </div>
            <div class="row my-4">
                <p>Setelah mendapatkan bobot kriteria selanjutnya menghitung nilai eigen diperoleh dengan mengalikan
                    matriks perbandingan awal dengan vektor bobot:
                </p>
                <p class="formula">\[ \lambda_{\text{max}, i} = \sum_{j=1}^n A_{ij} \cdot \text{Bobot}_j \]
                </p>
                <h2>Tabel Nilai Eigen</h2>
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        @foreach ($criterias as $item)
                            <th scope="col">{{ $item->code }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                    <tr>
                        @foreach ($eigenValue as $eigen)
                            <td scope="col">{{ $eigen }}</td>
                        @endforeach
                        <th>{{ collect($eigenValue)->sum() }}</th>
                    </tr>
                </table>
            </div>
            <div class="row my-4">
                <p>Untuk memastikan konsistensi dalam penilaian, Consistency Index (CI) dihitung dengan rumus:</p>
                <p class="formula">\[ \text{CI} = \frac{\lambda_{\text{max}} - n}{n -
                    1}=\frac{\\{{ collect($eigenValue)->sum() }} -
                    {{ $criteria->count() }}}{\\{{ $criteria->count() }} - 1}=\text{{ $ci }} \]</p>
                <br>
                <h4>RI = {{ $irc }}</h4>
                <p>Consistency Ratio (CR) dihitung dengan membandingkan CI dengan Random Index (RI):</p>
                <p class="formula">\[ \text{CR} =
                    \frac{\text{CI}}{\text{RI}}=\frac{\\{{ $ci }}}{\\{{ $irc }}}=\text{{ $cr }}\]
                </p>
                <p>Jika nilai CR < 0.1 (10%), maka matriks tersebut konsisten, dan bobot dapat digunakan untuk
                        keputusan.</p>
            </div>
            <div class="row my-4">
                <h1>Perhitungan Pemeringkatan Alternatif Menggunakan Metode WASPAS</h1>
                <h2>Tabel Nilai Dari Setiap Alternatif</h2>
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        <th scope="col">Alternative</th>
                        @foreach ($criterias as $criteria)
                            <th scope="col">{{ $criteria->code }}</th>
                        @endforeach
                    </tr>
                    @foreach ($alternatives as $baris => $alternative)
                        <tr>
                            <th>{{ $alternative->name }}</th>
                            @foreach ($criterias as $kolom => $criteria)
                                <td>{{ $alternativeValue[$kolom][$baris] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="table-secondary">
                        <th>Tipe Kriteria</th>
                        @foreach ($criterias as $criteria)
                            <td>{{ $criteria->type_of_criteria }}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div class="row my-4">
                <h2>Normalisasi Matrix Keputusan</h2>
                <p>Pada tahap ini melakukan normalisasi nilai alternatif berdasarkan tipe kriterianya masing-masing:
                </p>
                <p>Untuk kriteria keuntungan (benefit):</p>
                <p class="formula">\[ r_{ij} = \frac{x_{ij}}{\text{max}_{i}(x_{ij})} \]</p>
                <p>Untuk kriteria biaya (cost):</p>
                <p class="formula">\[ r_{ij} = \frac{\text{min}_{i}(x_{ij})}{x_{ij}} \]</p>
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        <th scope="col">Alternative</th>
                        @foreach ($criterias as $criteria)
                            <th scope="col">{{ $criteria->code }}</th>
                        @endforeach
                    </tr>
                    @foreach ($alternatives as $baris => $alternative)
                        <tr>
                            <th>{{ $alternative->name }}</th>
                            @foreach ($criterias as $kolom => $criteria)
                                <td>{{ $matrixKeputusanNormalisasi[$kolom][$baris] }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="row my-4">
                <h2>Menghitung nilai Qi</h2>
                <p>Setelah melakukan normalisasi selanjutnya menentukan nilai Qi dari setiap alternatif menggunakan
                    rumus seperti dibawah ini:</p>
                <p class="formula">\[
                    Q_i = 0.5 \sum_{i=0}^n X_{ij} W + 0.5 \prod_{j=1}^n (X_{ij})^{W_j}
                    \]</p>

                <h3>Di mana:</h3>
                <p>\( Q_i \) = Nilai dari Q ke-i</p>
                <p>\( X_{ij} W \) = Perkalian nilai \( X_{ij} \) dengan bobot (W)</p>
                <p>\( 0.5 \) = Ketetapan</p>
                <h2>Hasil perangkingan alternatif berdasarkan nilai Qi dari tiap alternatif</h2>
                <table class="table table-bordered table-hover text-center">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Alternatif</th>
                        <th scope="col">Nilai Preferensi (Qi)</th>
                    </tr>
                    @foreach ($hasilPerangkingan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['qi'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
@endsection
