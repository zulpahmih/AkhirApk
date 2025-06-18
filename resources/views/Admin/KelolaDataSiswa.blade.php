@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Data Siswa</h1>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="mb-3 mb-md-0">
                        <!-- Tombol Tambah -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalInsertSiswa">
                            <i class="fa fa-plus"></i> Tambah
                        </button>

                    </div>

                    <!-- Form Search -->
                    <form action="{{ route('show_kelola_data_siswa') }}" method="GET" class="row align-items-center mb-4">
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
                                <a href="{{ route('show_kelola_data_siswa') }}"
                                    class="btn btn-warning font-weight-bold ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Kelas</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Orang Tua</th>
                                <th>Pekerjaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ asset('storage/foto_siswa/' . $s->foto) }}" target="_blank"
                                            rel="noopener noreferrer">
                                            <img src="{{ asset('storage/foto_siswa/' . $s->foto) }}" alt="Foto Siswa"
                                                width="60" class="img-thumbnail">
                                        </a>
                                    </td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($s->kelasJurusan && $s->kelasJurusan->kelas && $s->kelasJurusan->jurusan)
                                            {{ $s->kelasJurusan->kelas->kelas }} -
                                            {{ $s->kelasJurusan->jurusan->nama_jurusan }}
                                        @else
                                            <span class="text-danger">Data tidak valid</span>
                                        @endif
                                    </td>
                                    <td>{{ $s->no_hp }}</td>
                                    <td>{{ $s->alamat }}</td>
                                    <td>{{ $s->orangtua->nama ?? '-' }} </td>
                                    <td>{{ $s->orangtua->pekerjaan ?? '-' }}</td>
                                    <td>
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center align-items-center">

                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2"
                                                onclick="editSiswa({{ $s->id }})">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('destroy_siswa', $s->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus data siswa ini?')" class="mb-0">
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

        <!-- /.content -->

        <!-- Modal Input Siswa -->
        <div class="modal fade" id="ModalInsertSiswa" tabindex="-1" role="dialog" aria-labelledby="modalInputSiswaLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('store_siswa') }}" method="POST" id="formInputSiswa" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalInputSiswaLabel">Tambah Data Siswa</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <div class="form-row">
                                <!-- NIS -->
                                <div class="form-group col-md-6">
                                    <label for="nis">NIS</label>
                                    <input type="text" name="nis" id="nis" class="form-control" required>
                                </div>

                                <!-- Nama -->
                                <div class="form-group col-md-6">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="form-group col-md-6">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- No HP -->
                                <div class="form-group col-md-6">
                                    <label for="no_hp">No. HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control">
                                </div>

                                <!-- Kelas Jurusan -->
                                <div class="form-group col-md-6">
                                    <label for="kelas_jurusan_id">Kelas Jurusan</label>
                                    <select name="kelas_jurusan_id" id="kelas_jurusan_id" class="form-control" required>
                                        <option value="">-- Pilih Kelas Jurusan --</option>
                                        @foreach ($kelasJurusanList as $kj)
                                            <option value="{{ $kj->id }}">{{ $kj->kelas->kelas }} -
                                                {{ $kj->jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Foto Siswa -->
                                <div class="form-group col-md-6">
                                    <label for="foto">Foto Siswa</label>
                                    <input type="file" name="foto" id="foto" class="form-control-file"
                                        accept="image/*" onchange="previewFoto(event)">
                                    <img id="fotoPreview" src="#" alt="Preview Foto"
                                        class="img-fluid mt-2 border rounded d-none" style="max-height: 180px;" />
                                </div>

                                <!-- Alamat -->
                                <div class="form-group col-12">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal Input Siswa -->


        <!-- Modal Edit Data Siswa -->
        <div class="modal fade" id="editSiswaModal" tabindex="-1" role="dialog" aria-labelledby="editSiswaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="editSiswaForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="editSiswaModalLabel">Edit Data Siswa</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <input type="hidden" id="edit_siswa_id" name="id">

                            <div class="form-row">
                                <!-- NIS -->
                                <div class="form-group col-md-6">
                                    <label for="edit_nis">NIS</label>
                                    <input type="text" class="form-control" id="edit_nis" name="nis" required>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="form-group col-md-6">
                                    <label for="edit_nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="form-group col-md-6">
                                    <label for="edit_tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="edit_tanggal_lahir"
                                        name="tanggal_lahir" required>
                                </div>

                                <!-- No HP -->
                                <div class="form-group col-md-6">
                                    <label for="edit_no_hp">No. HP</label>
                                    <input type="text" class="form-control" id="edit_no_hp" name="no_hp">
                                </div>

                                <!-- Kelas Jurusan -->
                                <div class="form-group col-md-6">
                                    <label for="edit_kelas_jurusan_id">Kelas Jurusan</label>
                                    <select class="form-control" id="edit_kelas_jurusan_id" name="kelas_jurusan_id"
                                        required>
                                        <option value="">-- Pilih Kelas Jurusan --</option>
                                        @foreach ($kelasJurusanList as $kj)
                                            <option value="{{ $kj->id }}">{{ $kj->kelas->kelas }} -
                                                {{ $kj->jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Foto -->
                                <div class="form-group col-md-6">
                                    <label for="edit_foto">Foto Siswa</label>
                                    <input type="file" class="form-control-file" id="edit_foto" name="foto"
                                        accept="image/*" onchange="previewFotoEdit(event)">
                                    <img id="fotoEditPreview" src="#" alt="Preview Foto"
                                        class="img-fluid mt-2 border rounded d-none" style="max-height: 180px;" />
                                </div>

                                <!-- Alamat -->
                                <div class="form-group col-12">
                                    <label for="edit_alamat">Alamat</label>
                                    <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal Edit Data Siswa -->

    </div>
@endsection

@push('scripts')
    <script>
        function editSiswa(id) {
            $.ajax({
                url: '/Admin/Halaman-ModalSiswa/data/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let form = $('#editSiswaForm');
                    form.attr('action', '/Admin/Halaman-ModalSiswa/update/' + id);

                    $('#edit_siswa_id').val(data.id);
                    $('#edit_nis').val(data.nis);
                    $('#edit_nama').val(data.nama);
                    $('#edit_tanggal_lahir').val(data.tanggal_lahir);
                    $('#edit_no_hp').val(data.no_hp);
                    $('#edit_alamat').val(data.alamat);

                    let kelasJurusanOptions = '<option value="">-- Pilih Kelas Jurusan --</option>';
                    @foreach ($kelasJurusanList as $kj)
                        kelasJurusanOptions +=
                            `<option value="{{ $kj->id }}" ${data.kelas_jurusan_id == {{ $kj->id }} ? 'selected' : ''}>{{ $kj->kelas->kelas }} - {{ $kj->jurusan->nama_jurusan }}</option>`;
                    @endforeach
                    $('#edit_kelas_jurusan_id').html(kelasJurusanOptions);
                    $('#editSiswaModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengambil data siswa: ' + error);
                }
            });
        }
    </script>
    <script>
        function previewFoto(event) {
            const input = event.target;
            const preview = document.getElementById('fotoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.classList.remove('d-none');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
