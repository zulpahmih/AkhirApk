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
                    <h1 class="font-weight-bold mb-5">Halaman Kelola Data Pelanggaran Kelas</h1>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        <div class="mb-3 mb-md-0">
                            <!-- Tombol Tambah -->
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#ModalInsertPelanggaranKelas"><i class="fa-solid fa-plus"></i>Insert</button>
                            <button type="button" class="btn btn-secondary">
                                <i class="fa-solid fa-filter"></i>Filter
                            </button>
                        </div>

                        <!-- Form Search -->
                        <form action="#" method="GET" class="row g-2 align-items-center mb-2">
                            <div class="col-12 col-md-auto mb-3 mb-md-0">
                                <label for="search" class="col-form-label fw-semibold"
                                    style="min-width: 50px;">Cari</label>
                            </div>
                            <div class="col-12 col-md-auto mb-3 mb-md-0">
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="Nama siswa...">
                            </div>
                            <div class="col-12 col-md-auto">
                                <button class="btn btn-outline-primary w-100 w-md-auto" type="submit">Search</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Contoh data dummy --}}
                                <tr>
                                    <td>1</td>
                                    <td>Rudi Hartono</td>
                                    <td>Terlambat</td>
                                    <td>2025-05-07</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning me-1">Edit</a>
                                        <a href="#" class="btn btn-sm btn-info me-1">Surat</a>
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Tambahkan loop data pelanggaran di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->

        <!-- Modal Insert Data Pelanggaran Kelas -->
        <div class="modal fade" id="ModalInsertPelanggaranKelas" tabindex="-1" role="dialog"
            aria-labelledby="modalInsertLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('create_data_pelanggaran_kelas') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalInsertLabel">Tambah Data Pelanggaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Nama Siswa -->
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>
                                <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                            </div>
                            <!-- Input Nama Kelas -->
                            <div class="form-group">
                                <label for="tatatertib">Tata Tertib</label>
                                <select name="kelas" id="kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="Tawuran">X-TKJ</option>
                                    <option value="Bolos">XI-TKJ</option>
                                    <option value="Merokok">XII-TKJ</option>
                                    <option value="Merokok">dan lain-lain</option>
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tatatertib">Pelanggaran</label>
                                <select name="kelas" id="kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="Tawuran">Tawuran</option>
                                    <option value="Bolos">Bolos</option>
                                    <option value="Merokok">Merokok</option>
                                    <option value="Merokok">dan lain-lain</option>
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                            <!-- Tanggal -->
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal Insert Data Pelanggaran Kelas -->
    </div>
@endsection
