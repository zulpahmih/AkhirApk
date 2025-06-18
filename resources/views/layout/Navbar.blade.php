<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PPL STEKMAL</title>
    <link rel="icon" href="{{ asset('images/logo_stekmal.png') }}" type="image/png">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar_style.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="{{ route('landing') }}">
                <img src="{{ asset('images/logo_stekmal.png') }}" alt="logo_stekmal" id="nav-logo"
                    class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @php
                $isLanding = request()->routeIs('landing');
            @endphp

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ route('landing') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ route('index_landing_profile') }}">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold"
                            href="{{ $isLanding ? '#TataTertib' : route('index_landing_tata') . '#TataTertib' }}">
                            Tata Tertib
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold"
                            href="{{ $isLanding ? '#DaftarPoint' : route('index_landing_daftar_point') . '#DaftarPoint' }}">
                            Daftar Point
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ route('show_login') }}">
                            <i class="bi bi-box-arrow-in-right p-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>


        </div>
    </nav>
    <!-- Akhir Navbar -->

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gradient text-white pt-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <!-- Kolom Kontak -->
                <div class="col-12 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-telephone-fill me-3"></i><strong>(0263)261569</strong></li>
                        <li><i class="bi bi-envelope-fill me-3"></i><strong>info@stekmal.ac.id</strong></li>
                        <li>
                            <i class="bi bi-geo-alt-fill me-3"></i>
                            <strong>Jl. Raya No. 123, Cianjur, Jawa54JM+W4M, Gg. Kalimantan IV, Pamoyanan, Kec. Cianjur,
                                Kabupaten Cianjur, Jawa Barat 43211</strong>
                        </li>
                    </ul>
                </div>

                <!-- Kolom Media Sosial -->
                <div class="col-12 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Ikuti Kami</h5>
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <a href="#" class="btn btn-outline-light btn-circle me-3 mb-2 mb-md-0 social-icon-hover">
                            <i class="bi bi-instagram fs-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Kolom Lokasi -->
                <div class="col-12 col-md-4">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Lokasi Sekolah</h5>
                    <div class="map-responsive">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.5927715895164!2d107.13012337475607!3d-6.819281693178422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6852f6577704cf%3A0x8d6de2c545edb4cd!2sSMK%20AR-RAHMAH%20CIANJUR%20%2C%20STEKMAL!5e0!3m2!1sid!2sid!4v1745160654563!5m2!1sid!2sid"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center pt-4 mt-4 pb-3 border-top">
                <p class="mb-0">&copy; 2023 SIPEPES STEKMAL. All rights reserved.</p>
            </div>

        </div>
    </footer>

    <!-- Akhir Footer -->

    <!-- Scripts -->
    @stack('scripts')

    <script>
        let isScrolling;
        window.addEventListener('scroll', function() {
            let navbar = document.querySelector('.navbar');
            window.clearTimeout(isScrolling);

            if (window.scrollY > 70) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }

            isScrolling = setTimeout(function() {
                if (window.scrollY > 70) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            }, 20000);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
