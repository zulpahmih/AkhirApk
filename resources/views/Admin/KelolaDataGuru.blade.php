@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Data Guru</h1>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="mb-3 mb-md-0">
                        <!-- Tombol Tambah -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalInsertGuru"><i
                                class="fa-solid fa-plus"></i>Insert</button>
                    </div>

                    <!-- Form Search -->
                    <form action="{{ route('show_kelola_data_guru') }}" method="GET" class="row align-items-center mb-4">
                        <div class="col-12">
                            <label for="search" class="font-weight-bold">Cari</label>
                            <div class="input-group input-group-md">
                                <div class="input-group-prepend">
                                    <button type="submit" class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <input type="text" id="search" name="search" class="form-control"
                                    placeholder="Cari NIP, Nama, Kelas, atau Total Pelanggaran..." autocomplete="off">
                                <a href="{{ route('show_kelola_data_guru') }}"
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
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Jabatan</th>
                                <th>NO. HP</th>
                                <th>Wali Kelas</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gurus as $index => $guru)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ asset('storage/foto_guru/' . $guru->foto) }}" target="_blank"
                                            rel="noopener noreferrer">
                                            <img src="{{ asset('storage/foto_guru/' . $guru->foto) }}" alt="Foto Guru"
                                                width="60" class="img-thumbnail">
                                        </a>
                                    </td>
                                    <td>{{ $guru->nip }}</td>
                                    <td>{{ $guru->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d/m/Y') }}</td>
                                    <td>{{ $guru->jabatan }}</td>
                                    <td>{{ $guru->no_hp }}</td>
                                    <td>
                                        {{ $guru->waliKelas?->kelasJurusan?->kelas->kelas ?? '-' }} -
                                        {{ $guru->waliKelas?->kelasJurusan?->jurusan?->nama_jurusan ?? '-' }}
                                    </td>
                                    <td>{{ $guru->alamat }}</td>
                                    <td>
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center align-items-center">

                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2"
                                                onclick="editGuru({{ $guru->id }})">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('destroy_guru', $guru->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus?')" class="mb-0">
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


        <!-- Modal Input Guru -->
        <div class="modal fade" id="ModalInsertGuru" tabindex="-1" role="dialog" aria-labelledby="modalInsertGuruLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('store_guru') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalInsertGuruLabel">Tambah Data Guru</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <div class="form-row">
                                <!-- NIP -->
                                <div class="form-group col-md-6">
                                    <label for="nip">NIP</label>
                                    <input type="number" name="nip" id="nip" class="form-control" required>
                                </div>

                                <!-- Nama Lengkap -->
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

                                <!-- Jabatan -->
                                <div class="form-group col-md-6">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" name="jabatan" id="jabatan" class="form-control">
                                </div>

                                <!-- No HP -->
                                <div class="form-group col-md-6">
                                    <label for="no_hp">No. HP</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control">
                                </div>

                                <!-- Wali Kelas -->
                                <div class="form-group col-md-6">
                                    <label for="kelas_jurusan_id">Wali Kelas</label>
                                    <select name="kelas_jurusan_id" id="kelas_jurusan_id" class="form-control">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelasJurusanList as $kj)
                                            <option value="{{ $kj->id }}">{{ $kj->kelas->kelas }} -
                                                {{ $kj->jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Foto Guru -->
                                <div class="form-group col-md-6">
                                    <label for="foto">Foto Guru</label>
                                    <input type="file" name="foto" id="foto" class="form-control-file"
                                        accept="image/*" onchange="previewFoto(event)">
                                    <img id="fotoPreview" src="#" alt="Preview Foto"
                                        class="img-fluid mt-2 border rounded d-none" style="max-height: 180px;" />
                                </div>

                                <!-- Role -->
                                <div class="form-group col-md-6">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="">-- Pilih Role --</option>
                                        @foreach ($role as $roles)
                                            <option value="{{ $roles->id }}">{{ $roles->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Alamat -->
                                <div class="form-group col-12">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Masukkan Alamat" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal Input Guru -->

        <!-- Modal Edit Data Guru -->
        <div class="modal fade" id="editGuruModal" tabindex="-1" role="dialog" aria-labelledby="editGuruModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="editGuruForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_guru_id" name="id">

                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title" id="editGuruModalLabel">Edit Data Guru</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">
                            <div class="form-row">
                                <!-- NIP -->
                                <div class="form-group col-md-6">
                                    <label for="edit_nip">NIP</label>
                                    <input type="number" class="form-control" id="edit_nip" name="nip" required>
                                </div>

                                <!-- Nama -->
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

                                <!-- Jabatan -->
                                <div class="form-group col-md-6">
                                    <label for="edit_jabatan">Jabatan</label>
                                    <input type="text" class="form-control" id="edit_jabatan" name="jabatan">
                                </div>

                                <!-- No. HP -->
                                <div class="form-group col-md-6">
                                    <label for="edit_no_hp">No. HP</label>
                                    <input type="number" class="form-control" id="edit_no_hp" name="no_hp">
                                </div>

                                <!-- Wali Kelas -->
                                <div class="form-group col-md-6">
                                    <label for="edit_kelas_jurusan_id">Wali Kelas</label>
                                    <select class="form-control" id="edit_kelas_jurusan_id" name="kelas_jurusan_id">
                                        <option value="">-- Pilih Kelas Jurusan --</option>
                                        @foreach ($kelasJurusanList as $kj)
                                            <option value="{{ $kj->id }}">{{ $kj->kelas->kelas }} -
                                                {{ $kj->jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Foto -->
                                <div class="form-group col-md-6">
                                    <label for="edit_foto">Foto Guru</label>
                                    <input type="file" class="form-control-file" id="edit_foto" name="foto"
                                        accept="image/*" onchange="previewFotoEdit(event)">
                                    <img id="fotoEditPreview" src="#" alt="Preview Foto"
                                        class="img-fluid mt-2 border rounded d-none" style="max-height: 180px;">
                                </div>

                                <!-- Role -->
                                <div class="form-group col-md-6">
                                    <label for="edit_role">Role</label>
                                    <select name="role" id="edit_role" class="form-control" required>
                                        <option value="">-- Pilih Role --</option>
                                        @foreach ($role as $roles)
                                            <option value="{{ $roles->id }}">{{ $roles->nama_role }}</option>
                                        @endforeach
                                    </select>
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
        <!-- End Modal Edit Data Guru -->

    </div>



@endsection

@push('scripts')
    <script>
        function editGuru(id) {
            $.ajax({
                url: '/Admin/Halaman-ModalGuru/data/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let form = $('#editGuruForm');
                    form.attr('action', '/Admin/Halaman-ModalGuru/update/' + id);

                    $('#edit_guru_id').val(data.id);
                    $('#edit_nip').val(data.nip);
                    $('#edit_nama').val(data.nama);
                    $('#edit_tanggal_lahir').val(data.tanggal_lahir);
                    $('#edit_jabatan').val(data.jabatan);
                    $('#edit_no_hp').val(data.no_hp);
                    $('#edit_alamat').val(data.alamat);
                    $('#edit_kelas_jurusan_id').val(data.wali_kelas?.kelas_jurusan_id ?? '');
                    $('#edit_role').val(data.user?.roles_id ?? '');




                    $('#editGuruModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengambil data guru: ' + error);
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
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush


{{-- //let kelasJurusanOptions = '<option value="">-- Pilih Kelas Jurusan --</option>';
                    // @foreach ($kelasJurusanList as $kj)
                    //     kelasJurusanOptions +=
                    //         `<option value="{{ $kj->id }}" ${data.wali_kelas.kelas_jurusan_id == {{ $kj->id }} ? 'selected' : ''}>{{ $kj->kelas->kelas }} - {{ $kj->jurusan->nama_jurusan }}</option>`;
                    // @endforeach
                    // $('#edit_kelas_jurusan_id').html(kelasJurusanOptions); --}}
