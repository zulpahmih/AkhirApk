@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Data Pelanggaran Kelas</h1>

                <!-- Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#ModalInsertPelanggaranKelas">
                        <i class="fa-solid fa-plus"></i> Insert
                    </button>
                    <form action="#" method="GET" class="form-inline">
                        <label class="mr-2 font-weight-bold">Cari</label>
                        <input type="text" name="search" class="form-control mr-2" placeholder="Nama siswa...">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas - Jurusan</th>
                                <th>Pelanggaran</th>
                                <th>Poin</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggarans ?? [] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->siswa->kelasJurusan->kelas->kelas }} -
                                        {{ $item->siswa->kelasJurusan->jurusan->nama_jurusan }}</td>
                                    <td>{{ $item->dataPointPelanggaran->nama_pelanggaran }}</td>
                                    <td>{{ $item->dataPointPelanggaran->point_pelanggaran }}</td>
                                    <td>{{ $item->tanggal_pelanggaran }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-info">Surat</a>
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Pelanggaran -->
    <div class="modal fade" id="ModalInsertPelanggaranKelas" tabindex="-1" role="dialog"
        aria-labelledby="modalInsertLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('create_data_pelanggaran_kelas') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold">Tambah Data Pelanggaran Siswa</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">

                            <!-- Foto -->
                            <div class="form-group col-md-12">
                                <label for="foto">Foto Bukti Pelanggaran (Opsional)</label>
                                <input type="file" class="form-control-file" name="foto" id="foto">
                            </div>

                            <!-- Siswa -->
                            <div class="form-group col-md-6">
                                <label for="siswas_id">Nama Siswa</label>
                                <select id="siswas_id" name="siswas_id" class="form-control" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- NIS -->
                            <div class="form-group col-md-6">
                                <label for="nis_display">NIS</label>
                                <input type="text" id="nis_display" class="form-control" readonly>
                            </div>

                            <!-- Tanggal -->
                            <div class="form-group col-md-6">
                                <label for="tanggal_pelanggaran">Tanggal Pelanggaran</label>
                                <input type="date" name="tanggal_pelanggaran" id="tanggal_pelanggaran"
                                    class="form-control" required>
                            </div>

                            <!-- Tata Tertib -->
                            <div class="form-group col-md-6">
                                <label for="tata_tertib_id">Tata Tertib</label>
                                <select id="tata_tertib_id" name="tata_tertib_id" class="form-control" required>
                                    <option value="">-- Pilih Tata Tertib --</option>
                                    @foreach ($tataTertib as $t)
                                        <option value="{{ $t->id }}">{{ $t->nama_tata_tertib }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jenis Pelanggaran -->
                            <div class="form-group col-md-6">
                                <label for="data_point_pelanggarans_id">Jenis Pelanggaran</label>
                                <select id="data_point_pelanggarans_id" name="data_point_pelanggarans_id"
                                    class="form-control" required>
                                    <option value="">-- Pilih Pelanggaran --</option>
                                </select>
                            </div>

                            <!-- Point -->
                            <div class="form-group col-md-6">
                                <label for="point_display">Poin Pelanggaran</label>
                                <input type="text" id="point_display" class="form-control" readonly>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // === Tampilkan NIS setelah memilih siswa ===
            $('#siswas_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    $.get('/Guru/get-nis/' + id, function(data) {
                        $('#nis_display').val(data.nis);
                    });
                } else {
                    $('#nis_display').val('');
                }
            });

            // === Tampilkan pelanggaran setelah memilih tata tertib ===
            $('#tata_tertib_id').on('change', function() {
                let id = $(this).val();
                let pelanggaranSelect = $('#data_point_pelanggarans_id');
                pelanggaranSelect.empty().append('<option value="">-- Pilih Pelanggaran --</option>');

                if (id) {
                    $.get('/Guru/get-pelanggaran/' + id, function(data) {
                        data.forEach(function(item) {
                            pelanggaranSelect.append(
                                `<option value="${item.id}">${item.nama_pelanggaran}</option>`
                            );
                        });
                    });
                }
            });

            // === Tampilkan point pelanggaran setelah memilih jenis pelanggaran ===
            $('#data_point_pelanggarans_id').on('change', function() {
                let id = $(this).val();
                if (id) {
                    $.get('/Guru/get-point/' + id, function(data) {
                        $('#point_display').val(data.point_pelanggaran);
                    });
                } else {
                    $('#point_display').val('');
                }
            });

        });
    </script>
@endpush
