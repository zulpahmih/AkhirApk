@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <h1 class="font-weight-bold mb-5 mt-5">Daftar Konfirmasi Surat </h1>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Surat</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas - Jurusan</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($surats as $surat)
                                        @php
                                            $index = +1;
                                            $siswa = $surat->suratKeluar->siswa;
                                            $kelas = $siswa->kelasJurusan->kelas->kelas ?? '-';
                                            $jurusan = $siswa->kelasJurusan->jurusan->nama_jurusan ?? '-';
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $surat->kode_surat }}</td>
                                            <td>{{ $siswa?->nama }}</td>
                                            <td>{{ $kelas }} - {{ $jurusan }}</td>
                                            <td>{{ $surat->jenis_surat }}</td>
                                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_pembuatan)->translatedFormat('d F Y') }}
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-info"
                                                        data-id="{{ $surat->id }}" onclick="previewSurat(this)">
                                                        Preview
                                                    </button>

                                                    <button type="button" class="btn btn-success ml-1"
                                                        data-id="{{ $surat->id }}" onclick="showAccModal(this)">
                                                        ACC
                                                    </button>

                                                    <form action="{{ route('kepsek.surat.tolak', $surat->id) }}"
                                                        method="POST" class="d-inline-block ml-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Tolak surat ini?')">Tolak</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada surat menunggu.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ACC dengan Upload TTD -->
        <div class="modal fade" id="modalAccSurat" tabindex="-1" role="dialog" aria-labelledby="modalAccSuratLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="formAccSurat" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_surat" id="id_surat">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ACC Surat - Upload Tanda Tangan</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ttd_kepsek">Upload Tanda Tangan Kepala Sekolah (PNG/JPG)</label>
                                <input type="file" name="ttd_kepsek" id="ttd_kepsek" class="form-control" required
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Konfirmasi ACC</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Preview Surat -->
        <div class="modal fade" id="modalPreviewSurat" tabindex="-1" role="dialog" aria-labelledby="previewSuratLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-sm">
                    <div class="modal-header  text-dark">
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
        function previewSurat(button) {
            let id = $(button).data('id');
            $('#modalPreviewSurat').modal('show');
            $('#previewContent').html('<p class="text-center">Memuat...</p>');

            $.get('/KepalaSekolah/surat/preview/' + id, function(res) {
                $('#previewContent').html(res.html);
            }).fail(function() {
                $('#previewContent').html('<p class="text-danger text-center">Gagal memuat data surat.</p>');
            });
        }
    </script>

    <script>
        function showAccModal(button) {
            const suratId = $(button).data('id');
            $('#formAccSurat').attr('action', '/KepalaSekolah/surat/acc/' + suratId);
            $('#id_surat').val(suratId);
            $('#modalAccSurat').modal('show');
        }
    </script>
@endpush
