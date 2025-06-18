@extends('layout.Navbar')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing_style.css') }}">
@endpush

@section('content')
    <!-- Tata Tertib Section -->
    <section id="Tata" class="py-5" style="scroll-margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <div class="d-inline-block px-5 py-2 rounded-pill fw-bold fs-5 bg-white text-dark">
                        Tata Tertib
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Loop untuk menampilkan data tata tertib -->
                    <ol class="fw-bold fs-5 text-white">
                        @foreach ($tata as $item)
                            <li class="mb-2">{{ $item->nama_tata_tertib }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection
