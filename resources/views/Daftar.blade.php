@extends('layout.Navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/daftar_style.css') }}">
@endpush

@section('content')
    <div class="login-container">
        <div class="login-card">
            <img src="{{ asset('images/logo_stekmal.png') }}" alt="logo_stekmal" id="login_logo"
                class="d-inline-block align-text-top">
            <h2 class="system-name fs-4" style="padding-top: 20px;">
                <b>Daftar Akun</b>
            </h2>
            <p class="welcome-message fs-5 text-white">
                Sistem Pelaporan dan Pencatatan Pelanggaran Siswa
            </p>

            <form method="POST" action="{{ route('daftar_orangtua') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nis" class="form-label text-white">NIS Anak</label>
                        <input type="number" class="form-control" id="nis" name="nis"
                            placeholder="Masukkan NIS Anak" required onchange="CariSiswa(this.value)">
                        <span id="nis_ditemukan" style="display: none">Data Ditemukan </span>
                        <span id="nis_tidak_ditemukan" style="display: none" class="text-danger">Data Tidak Ditemukan</span>
                        <span id="nis_telah_terdaftar" style="display: none">Data NIS sudah Terdaftar</span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label text-white">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="Masukkan Nama Lengkap" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_hp" class="form-label text-white">Nomor HP</label>
                        <input type="number" class="form-control" id="no_hp" name="no_hp"
                            placeholder="Masukkan Nomor HP" required>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pekerjaan" class="form-label text-white">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                            placeholder="Masukkan Pekerjaan" required>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label text-white">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Masukkan Username" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label text-white">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan Password" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="alamat" class="form-label text-white">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan Alamat Lengkap"
                            required></textarea>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-login fw-bold text-white">Daftar</button>
                </div>

                <p class="text-center form-text">Sudah Punya Akun ? <a href="{{ route('show_login') }}">Login di sini</a>
                </p>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function CariSiswa(nis) {
            $.ajax({
                url: '/CariSiswa/' + nis,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data) {
                        if (data.status == 1) {
                            $('#nis_ditemukan').hide();
                            $('#nis_telah_terdaftar').show();
                            $('#nis_tidak_ditemukan').hide();
                        } else {
                            $('#nis_ditemukan').show();
                            $('#nis_telah_terdaftar').hide();
                            $('#nis_tidak_ditemukan').hide();
                        }

                    } else {
                        $('#nis_telah_terdaftar').hide();
                        $('#nis_ditemukan').hide();
                        $('#nis_tidak_ditemukan').show();
                    }
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengambil data siswa: ' + error);
                }
            });
        }
    </script>
@endpush
