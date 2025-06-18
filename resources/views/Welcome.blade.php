@extends('layout.Main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header Isi (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Cek jika ada session('status') dan tampilkan alert -->
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header isi -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <h3 class="m-0 pb-3">Selamat Datang di SIPEPES {{ Str::title(Auth::user()->nama) }}</h3>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
