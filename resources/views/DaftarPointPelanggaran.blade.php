@extends('layout.Navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing_style.css') }}">
@endpush

@section('content')
    <!-- Section Daftar Point Pelanggaran -->
    <section id="daftar-point" class="py-5" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <div class="d-inline-block px-5 py-2 rounded-pill fw-bold fs-5 bg-white text-dark">
                        Daftar Point Pelanggaran
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggaran</th>
                                    <th>Point</th>
                                </tr>
                            </thead>
                            <tbody class="text-white fw-semibold">
                                @foreach ($data as $datem)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $datem->nama_pelanggaran }}</td>
                                        <td>{{ $datem->point_pelanggaran }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
