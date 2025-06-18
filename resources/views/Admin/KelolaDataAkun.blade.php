@extends('layout.Main')

@section('title', 'Kelola Data Akun')

@section('content')
    <div class="content-wrapper">
        <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="font-weight-bold my-5">Halaman Kelola Data Akun</h1>

                <!-- Form Pencarian -->
                <form action="{{ route('show_lihat_data_pelanggaran') }}" method="GET" class="row align-items-center mb-4">
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
                            <a href="{{ route('show_lihat_data_pelanggaran') }}"
                                class="btn btn-warning font-weight-bold ml-2">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Tabel Data Akun -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @switch($user->role->nama_role)
                                            @case('guru_bk')
                                            @case('guru_wakel')

                                            @case('kepsek')
                                                {{ $user->guru->nama ?? '-' }}
                                            @break

                                            @case('siswa')
                                                {{ $user->siswa->nama ?? '-' }}
                                            @break

                                            @case('ortu')
                                                {{ $user->orangTua->nama ?? '-' }}
                                            @break

                                            @default
                                                -
                                        @endswitch
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td class="text-capitalize">{{ $user->role->nama_role ?? 'Tidak Diketahui' }}</td>
                                    <td>
                                        <div
                                            class="d-flex justify-content-center align-items-center flex-column flex-md-row">
                                            <a href="#" class="btn btn-sm btn-secondary mb-2 mb-md-0 mr-md-2">
                                                <i class="fa fa-refresh"></i> Reset
                                            </a>
                                            <form action="#" method="POST" onsubmit="return confirm('Yakin hapus?')"
                                                class="mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data pengguna ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
