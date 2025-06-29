@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Lihat Data Pelanggaran </h1>
                <form action="{{ route('show_lihat_data_pelanggaran') }}" method="GET"
                    class="row g-3 align-items-center mb-4">
                    <div class="col-12 col-md-12">
                        <label for="search" class="font-weight-bold">Cari</label>
                        <div class="input-group input-group-md w-100">
                            <div class="input-group-prepend">
                                <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                            </div>
                            <input type="text" id="search" name="search" class="form-control"
                                placeholder="Cari NIS, Nama, Kelas, atau Total Pelanggaran..."
                                aria-label="Search pelanggaran" autocomplete="off">
                            <a href={{ route('show_lihat_data_pelanggaran') }}
                                class="btn btn-warning font-weight-bold mx-1"><i
                                    class="fa-solid fa-arrow-left mx-1"></i>back</a>
                        </div>
                    </div>
                </form>


                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Total Pelanggaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapPelanggaran as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item['nis'] }}</td>
                                        <td>{{ $item['nama_siswa'] }}</td>
                                        <td>{{ $item['kelas_jurusan'] }}</td>
                                        <td>{{ $item['total_point'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
    </div>
@endsection
