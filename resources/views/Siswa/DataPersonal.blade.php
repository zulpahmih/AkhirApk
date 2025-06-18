@extends('layout.Main')

@section('title')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 pb-3"></h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid text-center">
                <!-- Gambar dan Point -->
                <div class="mb-4">
                    <img src="/images/logo_stekmal.png" alt="Foto Siswa" class="mb-2 rounded"
                        style="width: 150px; height: 150px">
                    <h5 class="fw-bold">Point Pelanggaran</h5>
                    <h2 class="fw-bold">75</h2>
                </div>

                <!-- Informasi Siswa -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-5">
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">NIS</strong>
                            <span style="width: 10px; text-align: left;">:</span>
                            <span style="text-align: left;">123456</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Nama</strong>
                            <span style="width: 10px; text-align: left;">:</span>
                            <span style="text-align: left;">Ahmad Fauzi</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Jurusan</strong>
                            <span style="width: 10px; text-align: left;">:</span>
                            <span style="text-align: left;">TKJ</span>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Kelas</strong>
                            <span style="width: 10px; text-align: left;">:</span>
                            <span style="text-align: left;">XII TKJ 2</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Orang Tua</strong>
                            <span style="width: 10px; text-align: left;">:</span>
                            <span style="text-align: left;">Bapak Fauzan</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Alamat</strong>
                            <span style="width: 10px; text-align: left;">:</span>
                            <span style="text-align: left;">Jl. Cianjur No.123</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pelanggaran -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Contoh data dummy --}}
                                <tr>
                                    <td>1</td>
                                    <td>Terlambat</td>
                                    <td>2025-05-07</td>
                                    <td>14:30:00</td>
                                </tr>
                                <!-- Tambahkan loop data pelanggaran di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
