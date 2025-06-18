@extends('layout.Navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing_style.css') }}">
@endpush

@section('content')
    <!-- Hero -->
    <section id="hero" class="vh-100 d-flex align-items-center text-center">

        <div class="container">
            <div class="row align-items-center">
                <!-- Kolom kiri: Logo + Nama Sekolah -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="/images/logo_stekmal.png" alt="Logo Sekolah" class="img-fluid mb-3" style="max-height: 200px;">
                    <h2 class="fw-bold">SMKS AR-RAHMAH CIANJUR</h2>
                    <h5 class="fw-bold">CIANJUR</h5>
                </div>

                <!-- Kolom kanan: Judul + Deskripsi + Tombol -->
                <div class="col-md-6">
                    <h1 class="fw-bold display-3">SiPePeS</h1>
                    <h5 class="fw-bold mb-4">Sistem Pelaporan Pencatatan Pelanggaran Siswa</h5>
                    <a href="{{ route('show_login') }}"
                        class="btn fw-bold px-4 bg-dark text-white btn-custom-dark">Mulai</a>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-0" style="border: 5px solid #000;">

    <!-- Tata Tertib Section -->
    <section id="TataTertib" class="py-5" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="d-inline-block px-5 py-2 rounded-pill fw-bold fs-5 bg-white text-dark">
                        Tata Tertib
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Loop untuk menampilkan data tata tertib -->
                    <ol class="fw-bold fs-5 text-white">
                        @foreach ($tata as $item)
                            <li class="mb-2">{{ $item->nama_tata_tertib }}</li>
                        @endforeach
                    </ol>
                    <!-- Tombol di tengah -->
                    <div class="text-center mt-4">
                        <a href={{ route('index_landing_tata') }} class="btn btn-outline-light px-4 py-2">Lihat Semua Tata
                            Tertib</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <hr class="my-0" style="border: 5px solid #000;">

    <!-- Section Daftar Point -->
    <section id="DaftarPoint" class="py-5" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="d-inline-block px-5 py-2 rounded-pill fw-bold fs-5 bg-white text-dark">
                        Daftar Point Pelanggaran
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggaran</th>
                                    <th>Point</th>
                                </tr>
                            </thead>
                            <tbody class="text-white fw-semibold">
                                @foreach ($data as $datem)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $datem->nama_pelanggaran }}</td>
                                        <td>{{ $datem->point_pelanggaran }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Tombol di tengah -->
                        <div class="text-center mt-4">
                            <a href={{ route('index_landing_daftar_point') }} class="btn btn-outline-light px-4 py-2">Lihat
                                Semua Pelanggaran</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <hr class="my-0" style="border: 5px solid #000;">

    <!-- Pelanggaran Section -->
    <section id="Pelanggaran" class="pelanggaran-section" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <div class="d-inline-block px-5 py-2 rounded-pill fw-bold fs-5 bg-white text-dark">
                        Pelanggaran
                    </div>
                </div>
            </div>
            <div class="section-title text-center">
                <p>Pelanggaran umum yang sering terjadi di lingkungan maupun di luar sekolah.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="iconbox text-danger">
                                <img src="{{ asset('icon/icon_warning.svg') }}" alt="">
                            </div>
                            <h5 class="card-title">Terlambat Masuk</h5>
                            <h1 class="text-dark"> 5</h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="iconbox text-warning">
                                <img src="{{ asset('icon/icon_baju.svg') }}" alt="">
                            </div>
                            <h5 class="card-title">Tidak Memakai Seragam / Atribut</h5>
                            <h1 class="text-dark"> 5</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="iconbox text-info">
                                <img src="{{ asset('icon/icon_duel.svg') }}" alt="">
                            </div>
                            <h5 class="card-title">Berkelahi</h5>
                            <h1 class="text-dark"> 5</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="iconbox text-success">
                                <img src="{{ asset('icon/icon_smoking.svg') }}" alt="">
                            </div>
                            <h5 class="card-title">Merokok</h5>
                            <h1 class="text-dark"> 5</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="icon">
                                <img src="{{ asset('icon/icon_bendera.svg') }}" alt="">
                            </div>
                            <h5 class="card-title">Tidak / Terlambat Mengikuti Upacara</h5>
                            <h1 class="text-dark"> 5</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="iconbox text-secondary">
                                <img src="{{ asset('icon/icon_book.svg') }}" alt="">
                            </div>
                            <h5 class="card-title">Tidak Mengerjakan PR</h5>
                            <h1 class="text-dark"> 5</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
