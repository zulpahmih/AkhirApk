@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Data Point Pelanggaran </h1>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="mb-3 mb-md-0">
                        <!-- Tombol Tambah -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#ModalDataPointPelanggaran"><i class="fa-solid fa-plus"></i>Tambah</button>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tata Tertib</th>
                                <th>Nama Pelanggaran</th>
                                <th>Point Pelanggaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $lastTataTertibId = null;
                                $rowNumber = 1;
                            @endphp

                            @foreach ($pelanggarans as $pelanggaran)
                                <tr>
                                    @if ($lastTataTertibId !== $pelanggaran->tata_tertib_id)
                                        <td rowspan="{{ $pelanggaran->tataTertib->pelanggarans->count() }}"
                                            class="align-middle">
                                            {{ $pelanggaran->tataTertib->nama_tata_tertib }}
                                        </td>
                                        @php $lastTataTertibId = $pelanggaran->tata_tertib_id; @endphp
                                    @endif
                                    <td>{{ $pelanggaran->nama_pelanggaran }}</td>
                                    <td>{{ $pelanggaran->point_pelanggaran }}</td>
                                    <td>
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center align-items-center">

                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2"
                                                onclick="editPelanggaran({{ $pelanggaran->id }})">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('data_point_pelanggaran_destroy', $pelanggaran->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin hapus?')" class="mb-0">
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

        <!-- Modal Tambah Data Point Pelanggaran -->
        <div class="modal fade" id="ModalDataPointPelanggaran" tabindex="-1" role="dialog"
            aria-labelledby="insertDataPelanggaranLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('data_point_pelanggaran_store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title font-weight-bold" id="insertDataPelanggaranLabel">Tambah Data Point
                                Pelanggaran</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <!-- Pilih Tata Tertib -->
                            <div class="form-group">
                                <label for="tata_tertib_id">Tata Tertib</label>
                                <select class="form-control" id="tata_tertib_id" name="tata_tertib_id" required>
                                    <option value="" disabled selected>-- Pilih Tata Tertib --</option>
                                    @foreach ($tata_tertibs as $tata)
                                        <option value="{{ $tata->id }}" data-nama="{{ $tata->nama_tata_tertib }}">
                                            {{ $tata->nama_tata_tertib }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Pelanggaran -->
                            <div class="form-group">
                                <label for="nama_pelanggaran">Nama Pelanggaran</label>
                                <input type="text" class="form-control" id="nama_pelanggaran" name="nama_pelanggaran"
                                    required>
                            </div>

                            <!-- Point Pelanggaran -->
                            <div class="form-group">
                                <label for="point_pelanggaran">Point Pelanggaran</label>
                                <input type="number" class="form-control" id="point_pelanggaran" name="point_pelanggaran"
                                    required>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal Tambah Data Point Pelanggaran -->


        <!-- Modal Edit Data Point Pelanggaran -->
        <div class="modal fade" id="ModalEditDataPointPelanggaran" tabindex="-1" role="dialog"
            aria-labelledby="editDataPointPelanggaranLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="formEditPelanggaran" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title font-weight-bold" id="editDataPointPelanggaranLabel">Edit Data Point
                                Pelanggaran</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <!-- Pilih Tata Tertib -->
                            <div class="form-group">
                                <label for="edit_tata_tertib_id">Tata Tertib</label>
                                <select class="form-control" id="edit_tata_tertib_id" name="tata_tertib_id" required>
                                    @foreach ($tata_tertibs as $tata)
                                        <option value="{{ $tata->id }}" id="tata-option-{{ $tata->id }}">
                                            {{ $tata->nama_tata_tertib }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Pelanggaran -->
                            <div class="form-group">
                                <label for="edit_nama_pelanggaran">Nama Pelanggaran</label>
                                <input type="text" class="form-control" id="edit_nama_pelanggaran"
                                    name="nama_pelanggaran" required>
                            </div>

                            <!-- Point Pelanggaran -->
                            <div class="form-group">
                                <label for="edit_point_pelanggaran">Point Pelanggaran</label>
                                <input type="number" class="form-control" id="edit_point_pelanggaran"
                                    name="point_pelanggaran" required>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Modal Edit Data Point Pelanggaran -->


    </div>
@endsection

@push('scripts')
    <script>
        function editPelanggaran(id) {
            $.ajax({
                url: '/Admin/Halaman-DataPointPelanggaran/data/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var $form = $('#formEditPelanggaran');

                    $form.attr('action', '/Admin/Halaman-DataPointPelanggaran/update/' + data.id);
                    $form.attr('method', 'POST');

                    $('#edit_id').val(data.id);
                    $('#edit_nama_pelanggaran').val(data.nama_pelanggaran);
                    $('#edit_point_pelanggaran').val(data.point_pelanggaran);

                    // Paksa ubah dropdown secara eksplisit
                    $('#edit_tata_tertib_id option').prop('selected', false); // reset
                    $('#edit_tata_tertib_id option[value="' + data.tata_tertib_id + '"]').prop('selected',
                        true);

                    $('#ModalEditDataPointPelanggaran').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengambil data: ' + error);
                }
            });
        }
    </script>
@endpush
