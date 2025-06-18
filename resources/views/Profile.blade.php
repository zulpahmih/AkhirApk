@extends('layout.Navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing_style.css') }}">
@endpush

@section('content')
    <!-- Tata Tertib Section -->
    <section id="TataTertib" class="py-5" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <div class="d-inline-block px-5 py-2 rounded-pill fw-bold fs-5 bg-white text-dark">
                        Profile
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h3 class="mb-3 fw-bold" style="text-align: center;">Sistem Pelaporan dan Pencatatan Pelanggaran Siswa
                    </h3>
                    <p class="fs-5" style="text-align: justify;">
                        Aplikasi ini dirancang untuk membantu sekolah dalam mendokumentasikan setiap bentuk pelanggaran yang
                        dilakukan oleh siswa secara sistematis dan terstruktur.
                        Melalui sistem ini, Kepala Sekolah, Guru BK, Guru Wali kelas, Siswa, dan Orang Tua dapat
                        memantau data pelanggaran secara real-time,
                        mempercepat proses penanganan, serta meningkatkan kedisiplinan siswa.
                    </p>
                    <p class="fs-5" style="text-align: justify;">Oleh karena itu, tujuan
                        dibentuknya sistem ini adalah untuk menciptakan proses pengelolaan pelanggaran yang transparan,
                        akurat, dan mudah diakses oleh semua pihak terkait guna mendukung lingkungan belajar yang kondusif.
                    </p>
                </div>
            </div>



        </div>
    </section>
@endsection
