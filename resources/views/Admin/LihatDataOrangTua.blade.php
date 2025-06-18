@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold mb-5 mt-5">Halaman Lihat Data Orang Tua </h1>
                <form action="{{ route('show_kelola_data_orangtua') }}" method="GET" class="row g-3 align-items-center mb-4">
                    <div class="col-12 col-md-12">
                        <label for="search" class="font-weight-bold">Cari</label>
                        <div class="input-group input-group-md w-100">
                            <div class="input-group-prepend">
                                <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                            </div>
                            <input type="text" id="search" name="search" class="form-control"
                                placeholder="Cari NIS, Nama, Pekerjaan ...." aria-label="Search pelanggaran"
                                autocomplete="off">
                            <a href={{ route('show_kelola_data_orangtua') }}
                                class="btn btn-warning font-weight-bold mx-1"><i
                                    class="fa-solid fa-arrow-left mx-1"></i>kembali</a>
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
                                    <th>Username</th>
                                    <th>Nama Orang Tua</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS Siswa</th>
                                    <th>Pekerjaan</th>
                                    <th>No. Hp</th>
                                    <th>Alamat</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orangtua as $index => $ortu)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $ortu->user->username ?? '-' }}</td>
                                        <td>{{ $ortu->nama }}</td>
                                        <td>{{ $ortu->siswa->nama ?? '-' }}</td>
                                        <td>{{ $ortu->siswa->nis ?? '-' }}</td>
                                        <td>{{ $ortu->pekerjaan }}</td>
                                        <td>{{ $ortu->no_hp }}</td>
                                        <td>{{ $ortu->alamat }}</td>

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
