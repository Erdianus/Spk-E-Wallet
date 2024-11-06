@extends('users-page.layouts')
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
            "HTML-CSS": {
                scale: 250
            },
            displayAlign: 'left',
            displayIndent: '0',
        });
    </script>
@endsection
@section('title')
    Hasil Perangkingan SPK AHP-WASPAS
@endsection
@section('style')
    <style>
        .rank-badge {
            font-size: 1.5rem;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ranking-card {
            border-left: 5px solid #007bff;
            margin-bottom: 1rem;
        }

        .formula {
            font-size: 3em;
            margin-top: 0.5em;
            /* Adjust this value to control the spacing between formulas */
            margin-bottom: 0.5em;
            /* Adjust this value to control the spacing between formulas */

        }
    </style>
@endsection
@section('header-title')
    Hasil Perangkingan Rekomendasi
@endsection
@section('content')
    <div class="card p-4">
        <div class="ranking-list">
            @foreach ($hasilPerangkingan as $item)
                <div class="card border-primary mb-3">
                    <div class="row align-items-center ranking-card p-3">
                        <div class="col-auto">
                            <div class="rank-badge">{{ $loop->iteration }}</div>
                        </div>
                        <div class="col">
                            <h5 class="mb-0">{{ $item['name'] }}</h5>
                            {{-- <small class="text-muted">Highest value</small> --}}
                        </div>
                        <div class="col-auto">
                            <span class="fs-5">{{ $item['qi'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Proses Perhitungan --}}
    <div class="accordion mt-5" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Lihat Proses Perhitungan
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
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
        </div>
    </div>
@endsection
