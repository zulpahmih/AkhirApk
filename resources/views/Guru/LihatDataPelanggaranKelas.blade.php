@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header Isi (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0 pb-3"></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header isi -->

        <!-- Main content -->
        <section class="content">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="fw-bold mb-4">Halaman Lihat Data Pelanggaran Kelas</h1>
                    <button type="button" class="btn btn-secondary mb-2 ">
                        <i class="fa-solid fa-filter me-2"></i> Filter
                    </button>
                    <form action="#" method="GET" class="row g-2 align-items-center mb-4">
                        <div class="col-12 col-md-6">
                            <label for="search" class="col-form-label fw-semibold">Cari</label>
                            <input type="text" name="search" id="search" class="form-control w-100 w-md-75"
                                placeholder="Nama siswa...">
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <!-- Tabel Data -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Pelanggaran</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Contoh data dummy --}}
                                    <tr>
                                        <td>1</td>
                                        <td>55210</td>
                                        <td>Rudi Hartono</td>
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
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
