@extends('layout.Main')
@section('title')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid text-center">
                <!-- Gambar dan Point -->
                <div class="mb-5 mt-5">
                    <img src="{{ asset('images/logo_stekmal.png') }}" alt="Foto Siswa" class="mb-2 rounded"
                        style="width: 150px; height: 150px">
                    <h5 class="font-weight-bold">Point Pelanggaran</h5>
                    <h2 class="font-weight-bold">{{ $totalPoin }}</h2>
                </div>

                <!-- Informasi Siswa -->
                <div class="row justify-content-center mb-4">
                    <div class="col-md-5">
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">NIS</strong>
                            <span style="width: 10px;">:</span>
                            <span>{{ $siswa->nis }}</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Nama</strong>
                            <span style="width: 10px;">:</span>
                            <span>{{ $siswa->nama }}</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Jurusan</strong>
                            <span style="width: 10px;">:</span>
                            <span>{{ $siswa->KelasJurusan->jurusan->nama_jurusan }}</span>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Kelas</strong>
                            <span style="width: 10px;">:</span>
                            <span>{{ $siswa->KelasJurusan->kelas->kelas }}</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Orang Tua</strong>
                            <span style="width: 10px;">:</span>
                            <span>{{ $siswa->orangtua->nama }}</span>
                        </div>
                        <div class="mb-2 d-flex">
                            <strong style="width: 120px; text-align: left;">Alamat</strong>
                            <span style="width: 10px;">:</span>
                            <span>{{ $siswa->alamat }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Pelanggaran -->
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggaran</th>
                                    <th>Point</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswa->pelanggaransiswa as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->dataPointPelanggaran->nama_pelanggaran }}</td>
                                        <td>{{ $item->dataPointPelanggaran->point_pelanggaran }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pelanggaran)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->jam_pelanggaran)->format('H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Belum ada pelanggaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
