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
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pelanggaran)->format('d-m-Y') }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <button type="button" class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2"
                                            onclick="editPelanggaranKelas({{ $item->id }})">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
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

    <!-- Modal Edit Pelanggaran -->
    <div class="modal fade" id="ModalEditPelanggaranKelas" tabindex="-1" role="dialog"
        aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formEditPelanggaranKelas" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title font-weight-bold">Edit Data Pelanggaran Siswa</h5>
                        <button type="button" class="close text-dark" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-row">

                            <!-- Foto -->
                            <div class="form-group col-md-12">
                                <label for="edit_foto">Foto Bukti Pelanggaran (Opsional)</label>
                                <input type="file" class="form-control-file" name="foto" id="edit_foto">
                                <div id="preview_edit_foto" class="mt-2"></div>
                            </div>

                            <!-- Nama Siswa -->
                            <div class="form-group col-md-6">
                                <label for="edit_siswa_nama">Nama Siswa</label>
                                <input type="text" id="edit_siswa_nama" class="form-control" readonly>
                            </div>

                            <!-- NIS -->
                            <div class="form-group col-md-6">
                                <label for="edit_nis_display">NIS</label>
                                <input type="text" id="edit_nis_display" class="form-control" readonly>
                            </div>

                            <!-- Tanggal -->
                            <div class="form-group col-md-6">
                                <label for="edit_tanggal_pelanggaran">Tanggal Pelanggaran</label>
                                <input type="date" name="tanggal_pelanggaran" id="edit_tanggal_pelanggaran"
                                    class="form-control" required>
                            </div>

                            <!-- Tata Tertib -->
                            <div class="form-group col-md-6">
                                <label for="edit_tata_tertib_id">Tata Tertib</label>
                                <select id="edit_tata_tertib_id" name="tata_tertib_id" class="form-control" required>
                                    <option value="">-- Pilih Tata Tertib --</option>
                                    @foreach ($tataTertib as $t)
                                        <option value="{{ $t->id }}">{{ $t->nama_tata_tertib }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jenis Pelanggaran -->
                            <div class="form-group col-md-6">
                                <label for="edit_data_point_pelanggarans_id">Jenis Pelanggaran</label>
                                <select id="edit_data_point_pelanggarans_id" name="data_point_pelanggarans_id"
                                    class="form-control" required>
                                    <option value="">-- Pilih Jenis Pelanggaran --</option>
                                </select>
                            </div>

                            <!-- Point -->
                            <div class="form-group col-md-6">
                                <label for="edit_point_display">Poin Pelanggaran</label>
                                <input type="text" id="edit_point_display" class="form-control" readonly>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function editPelanggaranKelas(id) {
            $.ajax({
                url: '/Guru/get-data-pelanggaran/' + id, // pastikan route ini tersedia
                type: 'GET',
                success: function(response) {
                    const data = response.data;
                    const siswa = data.siswa;

                    // Set form action
                    $('#formEditPelanggaranKelas').attr('action', '/Guru/update-data-pelanggaran/' + data.id);

                    // Isi form
                    $('#edit_id').val(data.id);
                    $('#edit_siswa_nama').val(siswa.nama);
                    $('#edit_nis_display').val(siswa.nis);
                    $('#edit_tanggal_pelanggaran').val(data.tanggal_pelanggaran);
                    $('#edit_tata_tertib_id').val(data.tata_tertib_id).trigger('change');

                    // Preview foto
                    if (data.foto) {
                        $('#preview_edit_foto').html(
                            `<img src="/storage/${data.foto}" width="100" class="img-thumbnail">`);
                    } else {
                        $('#preview_edit_foto').html('');
                    }

                    // Ambil jenis pelanggaran sesuai tata tertib
                    $.get('/Guru/get-pelanggaran/' + data.tata_tertib_id, function(pelanggaranList) {
                        const select = $('#edit_data_point_pelanggarans_id');
                        select.empty().append(
                            '<option value="">-- Pilih Jenis Pelanggaran --</option>');

                        pelanggaranList.forEach(function(pel) {
                            const selected = pel.id == data.data_point_pelanggarans_id ?
                                'selected' : '';
                            select.append(
                                `<option value="${pel.id}" ${selected}>${pel.nama_pelanggaran}</option>`
                            );
                        });

                        // Tampilkan point jika tersedia
                        if (data.data_point_pelanggarans_id) {
                            $.get('/Guru/get-point/' + data.data_point_pelanggarans_id, function(
                                point) {
                                $('#edit_point_display').val(point.point_pelanggaran);
                            });
                        } else {
                            $('#edit_point_display').val('');
                        }
                    });

                    // Tampilkan modal
                    $('#ModalEditPelanggaranKelas').modal('show');
                },
                error: function() {
                    alert('Gagal mengambil data pelanggaran.');
                }
            });
        }
    </script>

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
