@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header Isi (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Surat Peringatan atau Keluar</h1>
                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="mb-3 mb-md-0">
                        <!-- Tombol Tambah -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKelolaSurat"><i
                                class="fa-solid fa-plus"></i>Insert</button>
                    </div>

                    <!-- Form Search -->
                    <form action="{{ route('show_kelola_surat') }}" method="GET" class="row align-items-center mb-4">
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
                                <a href="{{ route('show_kelola_surat') }}" class="btn btn-warning font-weight-bold ml-2">
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
                                <th>Kode Surat</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis_Surat</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suratList as $index => $surat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $surat->dokumenSurat->kode_surat }}</td>
                                    <td>{{ $surat->siswa->nis }}</td>
                                    <td>{{ $surat->siswa->nama }}</td>
                                    <td>{{ $surat->siswa->kelasJurusan->kelas->kelas ?? '-' }} -
                                        {{ $surat->siswa->kelasJurusan->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>{{ $surat->dokumenSurat->jenis_surat }}</td>
                                    <td>
                                        @if ($surat->dokumenSurat->status == 0)
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif ($surat->dokumenSurat->status == 1)
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($surat->dokumenSurat->tanggal_pembuatan)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">

                                        {{-- Tombol Lihat/Unduh hanya jika status ACC --}}
                                        @if ($surat->dokumenSurat->status == 1)
                                            <a href="{{ asset($surat->dokumenSurat->link_file) }}" target="_blank"
                                                class="btn btn-sm btn-primary mb-2">
                                                <i class="fa fa-download"></i> Unduh
                                            </a>
                                        @endif

                                        {{-- Tombol Preview dan Hapus --}}
                                        <div
                                            class="d-flex flex-column flex-md-row align-items-center justify-content-center">

                                            {{-- Tombol Preview --}}
                                            <button type="button" class="btn btn-sm btn-info mb-2 mb-md-0 me-md-2"
                                                data-id="{{ $surat->id }}" onclick="previewSurat(this)">
                                                <i class="fa fa-eye"></i> Preview
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('hapus_surat', $surat->dokumenSurat->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin ingin menghapus surat ini?')"
                                                class="mb-0 ml-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Belum ada surat dibuat</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header isi -->


    <!-- Modal Kelola Surat -->
    <div class="modal fade" id="modalKelolaSurat" tabindex="-1" role="dialog" aria-labelledby="modalKelolaSuratLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formKelolaSurat" method="POST" action="{{ route('store_surat') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalKelolaSuratLabel">Input Surat Peringatan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Kode Surat -->
                        <div class="form-group">
                            <label for="kode_surat">Kode Surat</label>
                            <input type="number" class="form-control" id="kode_surat" name="kode_surat" required
                                placeholder="Masukkan kode surat misal (001)">
                        </div>
                        <!-- Kelas Jurusan -->
                        <div class="form-group">
                            <label for="kelas_jurusan">Kelas & Jurusan</label>
                            <select class="form-control" id="kelas_jurusan" name="kelas_jurusan_id" required>
                                <option value="" disabled selected>-- Pilih Kelas & Jurusan --</option>
                                @foreach ($kelasJurusanList as $kj)
                                    <option value="{{ $kj->id }}">{{ $kj->kelas->kelas }} -
                                        {{ $kj->jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Siswa -->
                        <div class="form-group">
                            <label for="siswa">Pilih Siswa</label>
                            <select class="form-control" id="siswa" name="siswa_id" required>
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                <!-- Data siswa akan di-load via AJAX berdasarkan kelas_jurusan -->
                            </select>
                        </div>

                        <!-- Jenis Surat -->
                        <div class="form-group">
                            <label for="jenis_surat">Jenis Surat</label>
                            <input type="text" class="form-control" id="jenis_surat" name="jenis_surat" readonly
                                placeholder="Otomatis berdasarkan poin siswa">
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="(Opsional) Isi pesan atau catatan..."></textarea>
                        </div>

                        <!-- Tanggal -->
                        <div class="form-group">
                            <label for="tanggal">Tanggal Pembuatan</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal Kelola Surat -->

    <!-- Modal Preview Surat -->
    <div class="modal fade" id="modalPreviewSurat" tabindex="-1" role="dialog" aria-labelledby="previewSuratLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header  text-dark bg-info">
                    <h5 class="modal-title font-weight-bold" id="previewSuratLabel">
                        <i class="fas fa-eye mr-2"></i> Preview Surat
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="previewContent">
                    <div class="text-center text-muted py-4">
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Memuat...</span>
                        </div>
                        <p class="mt-3 mb-0">Memuat isi surat...</p>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <small class="text-muted font-weight-bold">Pastikan isi surat sesuai sebelum disetujui atau
                        ditolak.</small>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#kelas_jurusan').on('change', function() {
                var id = $(this).val();
                $('#siswa').html('<option value="">-- Memuat siswa... --</option>');
                $('#jenis_surat').val('');

                if (id) {
                    $.get('/Admin/get-siswa-poin/' + id, function(data) {
                        $('#siswa').html('<option value="">-- Pilih Siswa --</option>');
                        if (data.length === 0) {
                            $('#siswa').append(
                                '<option value="">Tidak ada siswa memenuhi kriteria</option>');
                        } else {
                            $.each(data, function(i, siswa) {
                                $('#siswa').append(
                                    `<option value="${siswa.id}">${siswa.nama} (Total Poin: ${siswa.total_poin})</option>`
                                );
                            });
                        }
                    });
                }
            });

            $('#siswa').on('change', function() {
                let selected = $(this).find('option:selected').text();
                let match = selected.match(/Total Poin: (\d+)/);

                if (match) {
                    let poin = parseInt(match[1]);
                    let jenis = poin >= 100 ? 'Surat Keluar' : poin >= 75 ? 'Surat Peringatan 2' : poin >=
                        50 ? 'Surat Peringatan 1' : '';
                    $('#jenis_surat').val(jenis);
                }
            });
        });
    </script>

    <script>
        function previewSurat(button) {
            let id = $(button).data('id');
            $('#modalPreviewSurat').modal('show');
            $('#previewContent').html('<p class="text-center">Memuat...</p>');

            $.get('/Admin/surat/preview/' + id, function(res) {
                $('#previewContent').html(res.html);
            }).fail(function() {
                $('#previewContent').html('<p class="text-danger text-center">Gagal memuat data surat.</p>');
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#siswa').on('change', function() {
                const siswaId = $(this).val();
                if (!siswaId) return;

                $.ajax({
                    url: '{{ route('validasi.surat') }}',
                    type: 'GET',
                    data: {
                        siswa_id: siswaId
                    },
                    success: function(response) {
                        if (response.status === 'ok') {
                            $('#jenis_surat').val(response.jenis_surat ?? 'Tidak memenuhi');

                            if (response.sudah_ada) {
                                alert("Surat " + response.jenis_surat +
                                    " untuk siswa ini sudah pernah di-ACC. Anda tidak bisa membuat surat yang sama."
                                );
                                $('#formKelolaSurat button[type="submit"]').prop('disabled',
                                    true);
                            } else {
                                $('#formKelolaSurat button[type="submit"]').prop('disabled',
                                    false);
                            }
                        }
                    },
                    error: function() {
                        alert('Gagal memuat data surat.');
                        $('#jenis_surat').val('');
                        $('#formKelolaSurat button[type="submit"]').prop('disabled', true);
                    }
                });
            });

            // Reset saat modal dibuka ulang
            $('#modalKelolaSurat').on('hidden.bs.modal', function() {
                $('#jenis_surat').val('');
                $('#formKelolaSurat button[type="submit"]').prop('disabled', false);
            });
        });
    </script>
@endpush
