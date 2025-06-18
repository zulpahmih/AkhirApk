@extends('layout.Main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Kelola Tata Tertib </h1>

                <!-- Alert Notifikasi -->
                @if (session('message'))
                    <div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                    </div>
                @endif


                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="mb-3 mb-md-0">
                        <!-- Tombol Tambah -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTata"><i
                                class="fa-solid fa-plus"></i>Tambah</button>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Tata Tertib</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tata as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_tata_tertib }}</td>
                                    <td>
                                        <div
                                            class="d-flex flex-column flex-md-row justify-content-center align-items-center">

                                            {{-- Tombol Edit --}}
                                            <button type="button" class="btn btn-warning btn-sm mb-2 mb-md-0 mr-md-2"
                                                onclick="editTata({{ $item->id }})">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('tata_destroy', $item->id) }}" method="POST"
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
        </section>
        <!-- /.content -->

        <!-- Modal Tambah Tata Tertib -->
        <div class="modal fade" id="ModalTata" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold" id="insertModalLabel">Tambah Tata Tertib</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ route('store_tata') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="namaTataTertib">Tata Tertib</label>
                                <textarea class="form-control" id="namaTataTertib" name="nama_tata_tertib" rows="5"
                                    placeholder="Masukkan Tata Tertib" required></textarea>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer px-0">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Tambah Tata Tertib -->


        <!-- Modal Edit Tata Tertib -->
        <div class="modal fade" id="editTata" tabindex="-1" role="dialog" aria-labelledby="editTataLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title font-weight-bold" id="editTataLabel">Edit Tata Tertib</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Form Start -->
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Method PUT untuk update --}}
                        <input type="hidden" name="id" id="edit_id">

                        <!-- Modal Body -->
                        <div class="modal-body px-4 py-3">
                            <div class="form-group">
                                <label for="EditNamaTataTertib">Tata Tertib</label>
                                <textarea class="form-control" id="EditNamaTataTertib" name="nama_tata_tertib" rows="5"
                                    placeholder="Masukkan Tata Tertib" required></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer px-4 py-3">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
        <!-- End Modal Edit Tata Tertib -->


    </div>
@endsection

@push('scripts')
    <script>
        function editTata(id) {
            $.ajax({
                url: '/Admin/Kelola-TataTertib/data/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var $form = $('#editForm');

                    // Set action dan method form
                    $form.attr('action', '/Admin/Kelola-TataTertib/update/' + data.id);
                    $form.attr('method', 'POST');

                    // Isi nilai input form dengan data dari server
                    $('#edit_id').val(data.id);
                    $('#EditNamaTataTertib').val(data.nama_tata_tertib);

                    // Tampilkan modal
                    $('#editTata').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengambil data: ' + error);
                }
            });
        }
    </script>
@endpush
