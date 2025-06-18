@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header  -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Data Pelanggaran Siswa</h1>
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="mb-3 mb-md-0">
                        <!-- Tombol Tambah -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#ModalPelanggaranSiswa"><i class="fa-solid fa-plus"></i>Insert</button>

                    </div>
                    <!-- Form Search -->
                    <form action="{{ route('show_kelola_data_pelanggaran_siswa') }}" method="GET"
                        class="row align-items-center mb-4">
                        <div class="col-12">
                            <label for="search" class="font-weight-bold">Cari</label>
                            <div class="input-group input-group-md">
                                <div class="input-group-prepend">
                                    <button type="submit" class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <input type="text" id="search" name="search" class="form-control"
                                    placeholder="Cari NIS, Nama, Kelas, atau Total Pelanggaran..." autocomplete="off">
                                <a href="{{ route('show_kelola_data_pelanggaran_siswa') }}"
                                    class="btn btn-warning font-weight-bold ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered  text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Foto Bukti</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas - Jurusan</th>
                                <th>Tata Tertib</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Point</th>
                                <th>Tanggal Pelanggaran</th>
                                <th>Tanggal Input</th>
                                <th>Tanggal Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggaran_siswa as $index => $pel)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($pel->foto)
                                            <a href="{{ asset('storage/bukti_pelanggaran/' . $pel->foto) }}"
                                                class="img-thumbnail" target="_blank">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $pel->siswa->nis }}</td>
                                    <td>{{ $pel->siswa->nama }}</td>
                                    <td>{{ $pel->siswa->kelasJurusan->kelas->kelas }} -
                                        {{ $pel->siswa->kelasJurusan->jurusan->nama_jurusan }}</td>
                                    <td>{{ $pel->tataTertib->nama_tata_tertib }}</td>
                                    <td>{{ $pel->dataPointPelanggaran->nama_pelanggaran }}</td>
                                    <td>{{ $pel->dataPointPelanggaran->point_pelanggaran }}</td>
                                    <td>{{ $pel->tanggal_pelanggaran }}</td>
                                    <td>{{ $pel->created_at }}</td>
                                    <td>{{ $pel->updated_at }}</td>
                                    <td class="text-center">
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center align-items-center">

                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2"
                                                onclick="editPelanggaran({{ $pel->id }})">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('destroy_pelanggaran_siswa', $pel->id) }}"
                                                method="POST" class="mb-0"
                                                onsubmit="return confirm('Yakin ingin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        </section>
        <!-- /.content -->

        <!-- Modal Tambah Pelanggaran Siswa -->
        <div class="modal fade" id="ModalPelanggaranSiswa" tabindex="-1" role="dialog"
            aria-labelledby="modalPelanggaranLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('store_data_pelanggaran_siswa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Modal Header -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title font-weight-bold" id="modalPelanggaranLabel">Tambah Pelanggaran Siswa
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="form-row">

                                <!-- Foto Bukti -->
                                <div class="form-group col-md-12">
                                    <label for="foto">Foto Bukti Pelanggaran (Opsional)</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto">
                                </div>

                                <!-- Kelas & Jurusan -->
                                <div class="form-group col-md-12">
                                    <label for="kelas_jurusan_id">Kelas & Jurusan</label>
                                    <select id="kelas_jurusan_id" name="kelas_jurusan_id" class="form-control" required>
                                        <option value="">-- Pilih Kelas Jurusan --</option>
                                        @foreach ($kelas_jurusan_list as $kj)
                                            <option value="{{ $kj->id }}">{{ $kj->kelas->kelas }} -
                                                {{ $kj->jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih Siswa -->
                                <div class="form-group col-md-6">
                                    <label for="siswa_id">Siswa</label>
                                    <select id="siswa_id" name="siswa_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Siswa --</option>
                                    </select>
                                </div>

                                <!-- NIS -->
                                <div class="form-group col-md-6" id="nis-container" style="display: none;">
                                    <label for="nis_display">NIS</label>
                                    <input type="text" id="nis_display" class="form-control" readonly>
                                </div>

                                <!-- Tata Tertib -->
                                <div class="form-group col-md-6">
                                    <label for="tata_tertib_id">Tata Tertib</label>
                                    <select id="tata_tertib_id" name="tata_tertib_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Tata Tertib --</option>
                                        @foreach ($tata_tertibs as $tata)
                                            <option value="{{ $tata->id }}">{{ $tata->nama_tata_tertib }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jenis Pelanggaran -->
                                <div class="form-group col-md-6">
                                    <label for="data_point_pelanggaran_id">Jenis Pelanggaran</label>
                                    <select id="data_point_pelanggaran_id" name="data_point_pelanggaran_id"
                                        class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Jenis Pelanggaran --</option>
                                        @foreach ($data_point_list as $point)
                                            <option value="{{ $point->id }}">{{ $point->nama_pelanggaran }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Point Pelanggaran -->
                                <div class="form-group col-md-6" id="point-container" style="display: none;">
                                    <label for="point_display">Point Pelanggaran</label>
                                    <input type="text" id="point_display" class="form-control" readonly>
                                    <input type="hidden" name="point_pelanggaran" id="point_pelanggaran_hidden">
                                </div>

                                <!-- Tanggal Pelanggaran -->
                                <div class="form-group col-md-6">
                                    <label for="tanggal_pelanggaran">Tanggal Pelanggaran</label>
                                    <input type="date" id="tanggal_pelanggaran" name="tanggal_pelanggaran"
                                        class="form-control" required>
                                </div>

                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal Tambah Pelanggaran Siswa -->


        <!-- Modal Edit Pelanggaran Siswa -->
        <div class="modal fade" id="ModalEditPelanggaranSiswa" tabindex="-1" role="dialog"
            aria-labelledby="modalEditPelanggaranLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="formEditPelanggaranSiswa" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Modal Header -->
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title font-weight-bold" id="modalEditPelanggaranLabel">Edit Pelanggaran Siswa
                            </h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <input type="hidden" id="edit_id" name="id">
                            <div class="form-row">

                                <!-- Foto Bukti -->
                                <div class="form-group col-md-12">
                                    <label for="edit_foto">Foto Bukti Pelanggaran (Opsional)</label>
                                    <input type="file" class="form-control-file" id="edit_foto" name="foto">
                                    <div id="preview_edit_foto" class="mt-2"></div>
                                </div>

                                <!-- Kelas & Jurusan -->
                                <div class="form-group col-md-12">
                                    <label for="display_kelas_jurusan_id">Kelas & Jurusan</label>
                                    <input type="text" id="display_kelas_jurusan_id" class="form-control" readonly>
                                </div>

                                <!-- Siswa -->
                                <div class="form-group col-md-6">
                                    <label for="edit_siswa_id_display">Siswa</label>
                                    <input type="text" id="edit_siswa_id_display" class="form-control" readonly>
                                </div>

                                <!-- NIS -->
                                <div class="form-group col-md-6">
                                    <label for="edit_nis_show">NIS</label>
                                    <input type="text" id="edit_nis_show" class="form-control" readonly>
                                </div>

                                <!-- Tata Tertib -->
                                <div class="form-group col-md-6">
                                    <label for="edit_tata_tertib_id">Tata Tertib</label>
                                    <select id="edit_tata_tertib_id" name="tata_tertib_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Tata Tertib --</option>
                                        @foreach ($tata_tertibs as $tata)
                                            <option value="{{ $tata->id }}">{{ $tata->nama_tata_tertib }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jenis Pelanggaran -->
                                <div class="form-group col-md-6">
                                    <label for="edit_data_point_pelanggaran_id">Jenis Pelanggaran</label>
                                    <select id="edit_data_point_pelanggaran_id" name="data_point_pelanggaran_id"
                                        class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Jenis Pelanggaran --</option>
                                    </select>
                                </div>

                                <!-- Point -->
                                <div class="form-group col-md-6" id="edit-point-container" style="display: none;">
                                    <label for="edit_point_display">Point Pelanggaran</label>
                                    <input type="text" id="edit_point_display" class="form-control" readonly>
                                    <input type="hidden" name="point_pelanggaran" id="edit_point_pelanggaran_hidden">
                                </div>

                                <!-- Tanggal Pelanggaran -->
                                <div class="form-group col-md-6">
                                    <label for="edit_tanggal_pelanggaran">Tanggal Pelanggaran</label>
                                    <input type="date" id="edit_tanggal_pelanggaran" name="tanggal_pelanggaran"
                                        class="form-control" required>
                                </div>

                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary text-white">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal Edit Pelanggaran Siswa -->



    </div>
@endsection

@push('scripts')
    <script>
        function editPelanggaran(id) {
            $.ajax({
                url: '/Admin/pelanggaran-siswa/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const data = response.data;
                    const kelas = response.kelas;
                    const jurusan = response.jurusan;

                    // === [1] Set form action ===
                    const form = $('#formEditPelanggaranSiswa');
                    form.attr('action', '/Admin/pelanggaran-siswa/update/' + id);

                    // === [2] Isi data siswa dan NIS ===
                    $('#edit_id').val(data.id);
                    $('#edit_siswa_id_display').val(data.siswa.nama);
                    $('#edit_nis_show').val(data.siswa.nis);

                    // === [3] Tampilkan kelas & jurusan (hanya display) ===
                    $('#display_kelas_jurusan_id').val(kelas.kelas + ' - ' + jurusan.nama_jurusan);

                    // === [4] Set hidden field kelas_jurusan_id dan trigger change jika perlu ===
                    $('#edit_kelas_jurusan_id').val(data.kelas_jurusan_id).trigger('change');

                    // === [5] Set tanggal pelanggaran ===
                    $('#edit_tanggal_pelanggaran').val(data.tanggal_pelanggaran);

                    // === [6] Tampilkan foto jika ada ===
                    if (data.foto) {
                        $('#preview_edit_foto').html(
                            `<img src="/storage/${data.foto}" width="100" class="img-thumbnail">`
                        );
                    } else {
                        $('#preview_edit_foto').html('');
                    }

                    // === [7] Set tata tertib dan ambil jenis pelanggaran ===
                    $('#edit_tata_tertib_id').val(data.tata_tertib_id);

                    $.ajax({
                        url: '/Admin/get-jenis-pelanggaran-by-tatatertib/' + data.tata_tertib_id,
                        type: 'GET',
                        success: function(pelanggaranList) {
                            // === [7.1] Isi select jenis pelanggaran ===
                            const jenisPelanggaranSelect = $('#edit_data_point_pelanggaran_id');
                            jenisPelanggaranSelect.empty().append(
                                '<option value="">-- Pilih Jenis Pelanggaran --</option>'
                            );

                            $.each(pelanggaranList, function(key, pelanggaran) {
                                const selected = pelanggaran.id == data
                                    .data_point_pelanggarans_id ? 'selected' : '';
                                jenisPelanggaranSelect.append(
                                    `<option value="${pelanggaran.id}" ${selected}>${pelanggaran.nama_pelanggaran}</option>`
                                );
                            });

                            // === [7.2] Ambil point pelanggaran berdasarkan jenis yang dipilih ===
                            if (data.data_point_pelanggarans_id) {
                                $.ajax({
                                    url: '/Admin/get-point-pelanggaran/' + data
                                        .data_point_pelanggarans_id,
                                    type: 'GET',
                                    success: function(pointData) {
                                        $('#edit_point_display').val(pointData
                                            .point_pelanggaran);
                                        $('#edit_point_pelanggaran_hidden').val(
                                            pointData.point_pelanggaran);
                                        $('#edit-point-container').show();
                                    },
                                    error: function() {
                                        $('#edit_point_display').val('');
                                        $('#edit_point_pelanggaran_hidden').val('');
                                        $('#edit-point-container').hide();
                                    }
                                });
                            }
                        },
                        error: function() {
                            alert('Gagal mengambil data jenis pelanggaran.');
                        }
                    });

                    // === [8] Tampilkan modal edit ===
                    $('#ModalEditPelanggaranSiswa').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengambil data pelanggaran siswa: ' + error);
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {

            // === 1. Dinamis siswa berdasarkan kelas jurusan (Tambah) ===
            $('#kelas_jurusan_id').on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/Admin/get-siswa-by-kelas-jurusan/' + id,
                        type: 'GET',
                        success: function(data) {
                            $('#siswa_id').empty().append(
                                '<option value="">-- Pilih Siswa --</option>');
                            $.each(data, function(key, siswa) {
                                $('#siswa_id').append('<option value="' + siswa.id +
                                    '">' + siswa.nama + '</option>');
                            });
                            $('#nis_display').val('');
                            $('#nis-container').hide();
                        },
                        error: function() {
                            alert('Gagal mengambil data siswa.');
                        }
                    });
                } else {
                    $('#siswa_id').empty().append('<option value="">-- Pilih Siswa --</option>');
                    $('#nis-container').hide();
                }
            });

            // === 2. Tampilkan NIS berdasarkan siswa (Tambah) ===
            $('#siswa_id').on('change', function() {
                var siswaId = $(this).val();
                if (siswaId) {
                    $.ajax({
                        url: '/Admin/get-detail-siswa/' + siswaId,
                        type: 'GET',
                        success: function(data) {
                            $('#nis_display').val(data.nis);
                            $('#nis-container').show();
                        },
                        error: function() {
                            $('#nis_display').val('');
                            $('#nis-container').hide();
                            alert('Gagal mengambil data NIS siswa.');
                        }
                    });
                } else {
                    $('#nis_display').val('');
                    $('#nis-container').hide();
                }
            });

            // === 3. Dinamis jenis pelanggaran berdasarkan tata tertib (Tambah) ===
            $('#tata_tertib_id').on('change', function() {
                var tataTertibId = $(this).val();
                if (tataTertibId) {
                    $.ajax({
                        url: '/Admin/get-jenis-pelanggaran-by-tatatertib/' + tataTertibId,
                        type: 'GET',
                        success: function(data) {
                            $('#data_point_pelanggaran_id').empty().append(
                                '<option value="">-- Pilih Jenis Pelanggaran --</option>');
                            $.each(data, function(key, pelanggaran) {
                                $('#data_point_pelanggaran_id').append(
                                    '<option value="' + pelanggaran.id + '">' +
                                    pelanggaran.nama_pelanggaran + '</option>');
                            });
                        },
                        error: function() {
                            alert('Gagal mengambil data jenis pelanggaran.');
                        }
                    });
                } else {
                    $('#data_point_pelanggaran_id').empty().append(
                        '<option value="">-- Pilih Jenis Pelanggaran --</option>');
                }
            });

            // === 4. Tampilkan point pelanggaran saat pelanggaran dipilih (Tambah) ===
            $('#data_point_pelanggaran_id').on('change', function() {
                var pelanggaranId = $(this).val();
                if (pelanggaranId) {
                    $.ajax({
                        url: '/Admin/get-point-pelanggaran/' + pelanggaranId,
                        type: 'GET',
                        success: function(data) {
                            $('#point_display').val(data.point_pelanggaran);
                            $('#point_pelanggaran_hidden').val(data.point_pelanggaran);
                            $('#point-container').show();
                        },
                        error: function() {
                            $('#point_display').val('');
                            $('#point-container').hide();
                            alert('Gagal mengambil point pelanggaran.');
                        }
                    });
                } else {
                    $('#point_display').val('');
                    $('#point-container').hide();
                }
            });

            // === Versi edit: kelas jurusan → siswa ===
            $('#edit_kelas_jurusan_id').on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/Admin/get-siswa-by-kelas-jurusan/' + id,
                        type: 'GET',
                        success: function(data) {
                            $('#edit_siswa_id').empty().append(
                                '<option value="">-- Pilih Siswa --</option>');
                            $.each(data, function(key, siswa) {
                                $('#edit_siswa_id').append('<option value="' + siswa
                                    .id + '">' + siswa.nama + '</option>');
                            });
                            $('#edit_nis_display').val('');
                            $('#edit-nis-container').hide();
                        },
                        error: function() {
                            alert('Gagal mengambil data siswa.');
                        }
                    });
                } else {
                    $('#edit_siswa_id').empty().append('<option value="">-- Pilih Siswa --</option>');
                    $('#edit-nis-container').hide();
                }
            });

            // === Versi edit: siswa → nis ===
            $('#edit_siswa_id').on('change', function() {
                var siswaId = $(this).val();
                if (siswaId) {
                    $.ajax({
                        url: '/Admin/get-detail-siswa/' + siswaId,
                        type: 'GET',
                        success: function(data) {
                            $('#edit_nis_display').val(data.nis);
                            $('#edit-nis-container').show();
                        },
                        error: function() {
                            $('#edit_nis_display').val('');
                            $('#edit-nis-container').hide();
                            alert('Gagal mengambil data NIS siswa.');
                        }
                    });
                } else {
                    $('#edit_nis_display').val('');
                    $('#edit-nis-container').hide();
                }
            });

            // === Versi edit: tata tertib → pelanggaran ===
            $('#edit_tata_tertib_id').on('change', function() {
                var tataTertibId = $(this).val();
                if (tataTertibId) {
                    $.ajax({
                        url: '/Admin/get-jenis-pelanggaran-by-tatatertib/' + tataTertibId,
                        type: 'GET',
                        success: function(data) {
                            $('#edit_data_point_pelanggaran_id').empty().append(
                                '<option value="">-- Pilih Jenis Pelanggaran --</option>');
                            $.each(data, function(key, pelanggaran) {
                                $('#edit_data_point_pelanggaran_id').append(
                                    '<option value="' + pelanggaran.id + '">' +
                                    pelanggaran.nama_pelanggaran + '</option>');
                            });
                        },
                        error: function() {
                            alert('Gagal mengambil data jenis pelanggaran.');
                        }
                    });
                } else {
                    $('#edit_data_point_pelanggaran_id').empty().append(
                        '<option value="">-- Pilih Jenis Pelanggaran --</option>');
                }
            });

            // === Versi edit: pelanggaran → point ===
            $('#edit_data_point_pelanggaran_id').on('change', function() {
                var pelanggaranId = $(this).val();
                if (pelanggaranId) {
                    $.ajax({
                        url: '/Admin/get-point-pelanggaran/' + pelanggaranId,
                        type: 'GET',
                        success: function(data) {
                            $('#edit_point_display').val(data.point_pelanggaran);
                            $('#edit_point_pelanggaran_hidden').val(data.point_pelanggaran);
                            $('#edit-point-container').show();
                        },
                        error: function() {
                            $('#edit_point_display').val('');
                            $('#edit-point-container').hide();
                            alert('Gagal mengambil point pelanggaran.');
                        }
                    });
                } else {
                    $('#edit_point_display').val('');
                    $('#edit-point-container').hide();
                }
            });

        });
    </script>
@endpush
