@extends('layout.Navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login_style.css') }}">
@endpush

@section('content')
    <div class="login-container">
        <div class="login-card" style= "margin-top:10px">
            <img src="{{ asset('images/logo_stekmal.png') }}" alt="logo_stekmal" id="login_logo"
                class="d-inline-block align-text-top">
            <h2 class="system-name fs-4" style="padding-top: 20px;">
                <b>Login Akun</b>
            </h2>
            <p class="welcome-message fs-5 text-white">
                Sistem Pelaporan dan Pencatatan Pelanggaran Siswa
            </p>

            <form method="POST" action="{{ route('login_submit') }} ">
                @csrf
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Username</label>
                    <input type="text" class="form-control" id="email" name="username"
                        placeholder="Masukkan Username Anda" required autofocus>
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan Password Anda" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-login fw-bold text-white">Masuk</button>
                </div>
                <p class="text-center form-text">Belum punya akun? <a href="{{ route('daftar') }}">Daftar di sini</a></p>
            </form>
        </div>
    </div>
@endsection
