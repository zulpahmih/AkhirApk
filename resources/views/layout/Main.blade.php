<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title> <!-- Judul Halaman Dinamis -->
    <link rel="icon" href="{{ asset('images/logo_stekmal.png') }}" type="image/png">
    <!-- Tambahan head lainnya -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .main-sidebar {
            background: linear-gradient(to right, #141e30, #243b55) !important;
        }

        .main-header {
            background: linear-gradient(to left, #141e30, #243b55) !important;
        }
    </style>

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @include('sweetalert::alert')

    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('images/logo_stekmal.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-primary navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>

            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto ">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img src="{{ asset('images/logo_stekmal.png') }}" class="img-size-32 img-circle elevation-2"
                            alt="User Image">
                        <span class="d-none d-md-inline text-white">{{ Auth::user()->nama }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-item">
                            <div class="media">
                                <img src="{{ asset('images/logo_stekmal.png') }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title mb-0">{{ Auth::user()->nama }}</h3>
                                    <p class="text-sm text-muted">{{ Auth::user()->nama_role }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-key mr-2"></i> Kelola Sandi
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('images/logo_stekmal.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SMK AR-RAHMAH</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info text-white">
                        <table class="table table-borderless text-white table-sm mb-0">
                            <tr>
                                <td class="pe-2">Username</td>
                                <td class="pe-1">:</td>
                                <td>{{ Auth::user()->username }}</td>
                            </tr>
                            <tr>
                                <td class="pe-2">Nama</td>
                                <td class="pe-1">:</td>
                                <td>{{ Str::title(Auth::user()->nama) }}</td>

                            </tr>
                            <tr>
                                <td class="pe-2">Sebagai</td>
                                <td class="pe-1">:</td>
                                <td>{{ Str::title(Auth::user()->role->nama_role) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">



                        {{-- MENU UNTUK GURU BK --}}
                        @if (Auth::user()->roles_id == 1)
                            <li class="nav-item">
                                <a href={{ route('show_dashboard') }}
                                    class="nav-link {{ request()->is('Admin/Dashboard*') ? 'active' : '' }}">
                                    <i class="fas fa-tachometer nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li
                                class="nav-item {{ request()->is(['Admin/KelolaDataPelanggaranSiswa*', 'Admin/LihatDataPelanggaran*', 'Admin/KelolaSurat*']) ? 'menu-open menu-is-opening' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is(['Admin/KelolaDataPelanggaranSiswa*', 'Admin/LihatDataPelanggaran*', 'Admin/KelolaSurat*']) ? ' active' : '' }}">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>ManajemenPelanggaran
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href={{ route('show_lihat_data_pelanggaran') }}
                                            class="nav-link {{ request()->is('Admin/LihatDataPelanggaran*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon "></i>
                                            <p>Lihat Data Pelanggaran</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href={{ route('show_kelola_data_pelanggaran_siswa') }}
                                            class="nav-link {{ request()->is('Admin/KelolaDataPelanggaranSiswa*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Data Pelanggaran Siswa</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('show_kelola_surat') }}"
                                            class="nav-link {{ request()->is('Admin/KelolaSurat*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Surat Peringatan atau Keluar</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item {{ request()->is(['Admin/KelolaDataAkun*', 'Admin/KelolaDataGuru*', 'Admin/KelolaDataSiswa*', 'Admin/KelolaDataOrangTua*']) ? 'menu-open menu-is-opening' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is(['Admin/KelolaDataAkun*', 'Admin/KelolaDataGuru*', 'Admin/KelolaDataSiswa*', 'Admin/KelolaDataOrangTua*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fas fa-file-signature "></i>
                                    <p>Manajemen Data
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href={{ route('show_kelola_data_akun') }}
                                            class="nav-link {{ request()->is('Admin/KelolaDataAkun*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Data Akun</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href={{ route('show_kelola_data_siswa') }}
                                            class="nav-link {{ request()->is('Admin/KelolaDataSiswa*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Data Siswa</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ">
                                        <a href="{{ route('show_kelola_data_guru') }}"
                                            class="nav-link {{ request()->is('Admin/KelolaDataGuru*') ? 'active' : '' }} ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Data Guru</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href={{ route('show_kelola_data_orangtua') }}
                                            class="nav-link {{ request()->is('Admin/KelolaDataOrangTua*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lihat Data Orang Tua</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item {{ request()->is(['Admin/Halaman-DataPointPelanggaran*', 'Admin/KelolaTataTertib*']) ? 'menu-open menu-is-opening' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is(['Admin/Halaman-DataPointPelanggaran*', 'Admin/KelolaTataTertib*']) ? 'active' : '' }}">
                                    <i class="nav-icon  fas fa-file-signature"></i>
                                    <p>Kelola Kebijakan
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href={{ route('index_data_point_pelanggaran') }}
                                            class="nav-link {{ request()->is('Admin/Halaman-DataPointPelanggaran*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Data Point Pelanggaran</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href={{ route('index_tata_tertib') }}
                                            class="nav-link {{ request()->is('Admin/KelolaTataTertib*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Tata Tertib</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- MENU UNTUK WALI KELAS --}}
                        @if (Auth::user()->roles_id == 2)
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>Pelanggaran Kelas
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('show_lihat_data_pelanggaran_kelas') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lihat Data Pelanggaran</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('show_kelola_data_pelanggaran_kelas') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelola Pelanggaran Kelas</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif

                        {{-- MENU UNTUK SISWA --}}
                        @if (Auth::user()->roles_id == 3)
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>Lihat Data
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('show_data_personal') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Personal</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages/layout/top-nav.html" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar Surat</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        {{-- MENU UNTUK ORANGTUA --}}
                        @if (Auth::user()->roles_id == 4)
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>Lihat Data Anak
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('show_data_anak') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Data Pelanggaran Anak</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages/layout/top-nav.html" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar Surat Anak</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        {{-- MENU UNTUK KEPALA SEKOLAH --}}
                        @if (Auth::user()->roles_id == 5)
                            <li
                                class="nav-item {{ request()->is(['KepalaSekolah/surat-menunggu*', 'KepalaSekolah/riwayat-surat*']) ? 'menu-open menu-is-opening' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is(['KepalaSekolah/surat-menunggu*', 'KepalaSekolah/riwayat-surat*']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>Manajemen Surat
                                        <i class="fas fa-angle-left right "></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('index_surat') }}"
                                            class="nav-link {{ request()->is('KepalaSekolah/surat-menunggu*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar Konfirmasi Surat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('kepsek.riwayat.surat') }}"
                                            class="nav-link {{ request()->is('KepalaSekolah/riwayat-surat*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Daftar Riwayat Surat</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href={{ route('show_lihat_data_pelanggaran') }}
                                    class="nav-link {{ request()->is('KepalaSekolah/LihatDataPelanggaran*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon "></i>
                                    <p>Lihat Data Pelanggaran</p>
                                </a>
                            </li>
                        @endif


                    </ul>
                </nav>
            </div>
        </aside>


        <!-- Content Wrapper. Contains page content -->
        @yield('content')

        <!-- /.content-wrapper -->
        <footer class="main-footer text-right">
            <strong>Copyright &copy; 2024-2025 <a href="https://adminlte.io">Stekmal</a>.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script> <!-- .js ditambahkan -->
    <!-- Sparkline -->
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script> <!-- .js ditambahkan -->
    <!-- JQVMap -->
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script> <!-- .js ditambahkan -->
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> <!-- .js ditambahkan -->
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script> <!-- .js ditambahkan -->
    <!-- daterangepicker -->
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script> <!-- .js ditambahkan -->
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> <!-- .js ditambahkan -->
    <!-- Summernote -->
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script> <!-- .js ditambahkan -->
    <!-- overlayScrollbars -->
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script> <!-- .js ditambahkan -->
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('lte/dist/js/pages/dashboard.js') }}"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>

</html>
