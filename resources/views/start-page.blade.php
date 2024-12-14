@extends('users-page.layouts')
@section('title')
    SPK E-Wallet Metode AHP-WASPAS
@endsection
@section('style')
    <style>
        h5 {
            font-weight: bold;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .card-body {
            padding: 2rem;
            background: white;
        }

        .list-group-item {
            padding: 1rem 1.5rem;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            border-left-color: var(--primary-color);
            background-color: var(--light-bg);
            transform: translateX(10px);
        }

        .list-group-numbered>.list-group-item {
            display: flex;
            align-items: center;
        }

        .list-group-numbered>.list-group-item::before {
            background-color: var(--primary-color);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .card-header h2 {
                font-size: 1.25rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endsection
@section('header-title')
    <h1 class="mt-4">Welcome to SPK E-Wallet</h1>
@endsection
@section('content')
    <div class="container mb-5">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Platform SPK E-Wallet Kami</h2>
            </div>
            <div class="card-body">
                <p>Selamat datang di platform Sistem Pendukung Keputusan (SPK) E-Wallet. Website ini dirancang untuk
                    membantu Anda menemukan e-wallet yang paling sesuai dengan kebutuhan Anda, menggunakan metode AHP
                    (Analytical Hierarchy Process) dan WASPAS (Weighted Aggregated Sum Product Assessment) dalam proses
                    perangkingan.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Tentang Platform Kami</h2>
            </div>
            <div class="card-body">
                <p>Platform ini menganalisis berbagai kriteria penting dalam penggunaan e-wallet dan membandingkannya dengan
                    preferensi Anda. Dengan menggunakan metode AHP-WASPAS, kami dapat memberikan rekomendasi e-wallet yang
                    paling relevan sesuai dengan kebutuhan spesifik Anda.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Kriteria Penilaian</h2>
            </div>
            <div class="card-body">
                <p>Dalam menentukan rekomendasi e-wallet, kami menggunakan beberapa kriteria penting berikut:</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5>User Friendly</h5>
                        <p>Mengukur seberapa mudah tampilan halaman-halaman yang ada di aplikasi mudah dimengerti.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Metode Top Up</h5>
                        <p>Menilai metode Top Up yang disediakan aplikasi untuk kemudahan pengisian saldo.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Real Time</h5>
                        <p>Mengukur kecepatan dalam melakukan transaksi yang real time.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Promo</h5>
                        <p>Mengevaluasi seberapa sering aplikasi memiliki promo yang menarik.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Merchant</h5>
                        <p>Menilai banyaknya penjual yang menggunakan e-wallet tersebut.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Keberagaman Fitur</h5>
                        <p>Mengukur seberapa banyak keberagaman fitur yang menarik dan bermanfaat.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>Rating Aplikasi</h5>
                        <p>Mempertimbangkan rating aplikasi yang ada di Play Store dan App Store.</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">E-Wallet yang Kami Rekomendasikan</h2>
            </div>
            <div class="card-body">
                <p>Berikut adalah daftar e-wallet yang telah kami kurasi dan nilai berdasarkan kriteria di atas:</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5>ShopeePay</h5>
                        <p>E-wallet terintegrasi dengan platform e-commerce Shopee, menawarkan cashback dan promo belanja
                            yang kompetitif.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>GoPay</h5>
                        <p>Bagian dari ekosistem Gojek dengan integrasi layanan transportasi, makanan, dan berbagai layanan
                            lainnya.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>OVO</h5>
                        <p>Menyediakan layanan finansial lengkap dengan jaringan merchant yang luas dan program loyalitas
                            points.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>DANA</h5>
                        <p>E-wallet dengan fokus pada kemudahan transfer dana dan pembayaran utilitas dengan berbagai promo
                            menarik.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>DOKU</h5>
                        <p>Platform pembayaran digital dengan layanan yang komprehensif untuk transaksi online dan offline.
                        </p>
                    </li>
                    <li class="list-group-item">
                        <h5>LinkAja</h5>
                        <p>E-wallet BUMN dengan keunggulan dalam pembayaran transportasi publik dan layanan pemerintah.</p>
                    </li>
                    <li class="list-group-item">
                        <h5>I-Saku</h5>
                        <p>E-wallet dari Indomaret dengan kemudahan top-up dan pembayaran di jaringan retail Indomaret.</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Mulai Menggunakan Platform</h2>
            </div>
            <div class="card-body">
                <p>Untuk mendapatkan rekomendasi e-wallet yang paling sesuai dengan kebutuhan Anda, ikuti langkah-langkah
                    berikut:</p>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Isi perbandingan kriteria sesuai dengan prioritas kebutuhan Anda.</li>
                    <li class="list-group-item">Sistem akan menganalisis preferensi Anda menggunakan metode AHP-WASPAS.</li>
                    <li class="list-group-item">Dapatkan rekomendasi e-wallet yang paling sesuai dengan kebutuhan Anda.</li>
                </ol>
                <p class="mt-4">Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi tim
                    dukungan kami.</p>
                <div class="row d-flex align-items-center">
                    <a href="{{ route('perbandingan-page') }}" class="btn btn-primary mt-3">Mulai Sekarang</a>
                </div>
            </div>
        </div>
    </div>
@endsection
</div>
