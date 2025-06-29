<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\OrangTuaController;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'landingpage'])->name('landing');


Route::get('/TataTertib', [HomeController::class, 'index_landing_tata'])->name('index_landing_tata');
Route::get('/Profile',[HomeController::class, 'index_landing_profile'])->name('index_landing_profile');
Route::get('/DaftarPointPelanggaran', [HomeController::class, 'index_landing_daftar_point'])->name('index_landing_daftar_point');
Route::get('/login', [HomeController::class, 'show_login'])->name('show_login');
Route::get('/daftar', [HomeController::class, 'daftar'])->name('daftar');

Route::post('/login', [AuthController::class, 'login_submit'])->name('login_submit');


Route::post('/register', [AuthController::class, 'register_submit'])->name('register_submit');

Route::post('/Daftar/Store', [AdminController::class, 'daftar_orangtua'])->name('daftar_orangtua');

Route::get('/CariSiswa/{nis}', [AdminController::class, 'cari_nis'])->name('cari_nis');


Route::middleware(['auth', 'roles:1,2,3,4,5'])->group(function () {
    Route::get('/Logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/Dashboard', [DashboardController::class, 'all_dashboard'])->name('all_dashboard');
});


Route::prefix('Admin')->middleware(['auth', 'roles:1'])->group(function () {

    Route::get('/Dashboard', [AdminController::class, 'show_dashboard'])->name('show_dashboard');

    // ROUTE Kelola Surat
    Route::get('/KelolaSurat', [AdminController::class, 'show_kelola_surat'])->name('show_kelola_surat');
    // buat surat
    Route::post('/InsertKelolaSurat', [AdminController::class, 'store_surat'])->name('store_surat');
    //get point siswa surat => 50
    Route::get('/get-siswa-poin/{id}', [AdminController::class,'getSiswaByKelasJurusanPoint'])->name('getSiswaByKelasJurusanPoint');
    //delete surat
    Route::delete('/admin/surat/{id}', [AdminController::class, 'hapus_surat'])->name('hapus_surat');
    //preview surat
    Route::get('/surat/preview/{id}', [AdminController::class, 'preview_admin'])->name('preview_admin');
    //validasi surat sama
    Route::get('/validasi-surat', [AdminController::class, 'cekSuratAcc'])->name('validasi.surat');




    // ROUTE ORANG TUA
    Route::get('/KelolaDataOrangTua', [AdminController::class, 'show_kelola_data_orangtua'])->name('show_kelola_data_orangtua');

    // ROUTE UNTUK TATA TERTIB
    Route::get('/KelolaTataTertib', [AdminController::class, 'index_tata_tertib'])->name('index_tata_tertib');
    Route::post('/InsertKelolaTata', [AdminController::class, 'store_tata'])->name('store_tata');
    Route::get('/Kelola-TataTertib/data/{id}',[AdminController::class, 'edit_tata'])->name('edit_tata');  
    Route::put('/Kelola-TataTertib/update/{id}',[AdminController::class, 'update_tata'])->name('update_tata');
    Route::delete('/Kelola-TataTertib/delete/{id}',[AdminController::class, 'tata_destroy'])->name('tata_destroy');
    

    // ROUTE UNTUK DATA POINT PELANGGARAN
    Route::get('/Halaman-DataPointPelanggaran', [AdminController::class, 'index_data_point_pelanggaran'])->name('index_data_point_pelanggaran');
    Route::post('/Halaman-DataPointPelanggaran', [AdminController::class, 'data_point_pelanggaran_store'])->name('data_point_pelanggaran_store');
    Route::delete('/Halaman-DataPointPelanggaran/{id}', [AdminController::class, 'data_point_pelanggaran_destroy'])->name('data_point_pelanggaran_destroy');
    Route::get('/Halaman-DataPointPelanggaran/data/{id}',[AdminController::class, 'edit_data_point_pelanggaran'])->name('edit_data_point_pelanggaran');  
    Route::put('/Halaman-DataPointPelanggaran/update/{id}',[AdminController::class, 'update_data_point_pelanggaran'])->name('update_data_point_pelanggaran');


    // untuk get filter data pelanggaran siswa
    Route::get('/get-siswa-by-kelas-jurusan/{id}', [AdminController::class, 'getSiswaByKelasJurusan'])->name('getSiswaByKelasJurusan');
    Route::get('/get-detail-siswa/{id}', [AdminController::class, 'getDetailSiswa'])->name('getDetailSiswa');
    Route::get('/get-jenis-pelanggaran-by-tatatertib/{id}', [AdminController::class, 'getJenisPelanggaranByTataTertib'])->name('getJenisPelanggaranByTataTertib');
    Route::get('/get-point-pelanggaran/{id}', [AdminController::class, 'getPointPelanggaran'])->name('getPointPelanggaran');


    // ROUTE UNTUK DATA PELANGGARAN SISWA
    Route::post('/store-pelanggaran-siswa', [AdminController::class, 'store_data_pelanggaran_siswa'])->name('store_data_pelanggaran_siswa');
    // Untuk ambil data pelanggaran siswa (AJAX)
    Route::get('/pelanggaran-siswa/{id}', [AdminController::class, 'getPelanggaranSiswaById']);
    // Untuk update data pelanggaran siswa
    Route::put('/pelanggaran-siswa/update/{id}', [AdminController::class, 'updatePelanggaranSiswa'])->name('update_pelanggaran_siswa');
    // Untuk hapus data pelanggaran siswa
    Route::delete('/pelanggaran-siswa/delete/{id}', [AdminController::class, 'destroyPelanggaranSiswa'])->name('destroy_pelanggaran_siswa');


    
    
    Route::get('/KelolaDataPelanggaranSiswa', [AdminController::class, 'show_kelola_data_pelanggaran_siswa'])->name('show_kelola_data_pelanggaran_siswa');

    // ROUTE UNTUK DATA AKUN
    Route::get('/KelolaDataAkun', [AdminController::class, 'show_kelola_data_akun'])->name('show_kelola_data_akun');
    



    // ROUTE UNTUK LIHAT DATA PELANGGARAN SISWA
    Route::get('/LihatDataPelanggaran', [AdminController::class, 'show_lihat_data_pelanggaran'])->name('show_lihat_data_pelanggaran');

    // ROUTE UNTUK DATA SISWA
    Route::get('/KelolaDataSiswa', [AdminController::class, 'show_kelola_data_siswa'])->name('show_kelola_data_siswa');
    Route::post('/InsertKelolaDataSiswa', [AdminController::class, 'store_siswa'])->name('store_siswa');
    Route::delete('/Halaman-ModalSiswa/delete/{id}', [AdminController::class, 'destroy_siswa'])->name('destroy_siswa');
    Route::get('/Halaman-ModalSiswa/data/{id}', [AdminController::class, 'edit_siswa'])->name('edit_siswa');
    Route::put('/Halaman-ModalSiswa/update/{id}', [AdminController::class, 'update_siswa'])->name('update_siswa');




    // ROUTE UNTUK DATA GURU
    Route::get('/KelolaDataGuru', [AdminController::class, 'show_kelola_data_guru'])->name('show_kelola_data_guru');
    Route::post('/InsertKelolaDataGuru', [AdminController::class, 'store_guru'])->name('store_guru');
    Route::delete('/HapusDataGuru/{id}', [AdminController::class, 'destroy_guru'])->name('destroy_guru');
    Route::get('/Halaman-ModalGuru/data/{id}', [AdminController::class, 'edit_guru'])->name('edit_guru');
    Route::put('/Halaman-ModalGuru/update/{id}', [AdminController::class, 'update_guru'])->name('update_guru');



});

Route::prefix('Guru')->middleware(['auth', 'roles:2'])->group(function () {


    Route::get('/LihatDataPelanggaranKelas', [GuruController::class, 'show_lihat_data_pelanggaran_kelas'])->name('show_lihat_data_pelanggaran_kelas');

    Route::get('/KelolaDataPelanggaranKelas', [GuruController::class, 'show_kelola_data_pelanggaran_kelas'])->name('show_kelola_data_pelanggaran_kelas');
    Route::post('/InsertKelolaDataPelanggaranKelas', [GuruController::class, 'store_data_pelanggaran_kelas'])->name('create_data_pelanggaran_kelas');
    // Ini yang diperbaiki:
    Route::get('/get-nis/{id}', [GuruController::class, 'getNis']);
    Route::get('/get-pelanggaran/{tataTertibId}', [GuruController::class, 'getPelanggaran']);
    Route::get('/get-point/{pelanggaranId}', [GuruController::class, 'getPoint']);

    Route::get('/get-data-pelanggaran/{id}', [GuruController::class, 'getDataPelanggaran']);
    Route::put('/update-data-pelanggaran/{id}', [GuruController::class, 'updateDataPelanggaran']);


    

});

Route::prefix('Siswa')->middleware(['auth', 'roles:3'])->group(function () {
    Route::get('/DataPesonal', [SiswaController::class, 'show_data_personal'])->name('show_data_personal');
   
});

Route::prefix('OrangTua')->middleware(['auth', 'roles:4'])->group(function () {
    Route::get('/DataAnak', [OrangTuaController::class, 'show_data_anak'])->name('show_data_anak');
   
});

Route::prefix('KepalaSekolah')->middleware(['auth', 'roles:5'])->group(function () {

    // Kepala Sekolah
    Route::get('/surat-menunggu', [KepalaSekolahController::class, 'index'])->name('index_surat');
    Route::post('/surat/acc/{id}', [KepalaSekolahController::class, 'acc'])->name('kepsek.surat.acc');
    Route::post('/surat/{id}/tolak', [KepalaSekolahController::class, 'tolak'])->name('kepsek.surat.tolak');
    Route::get('/surat/preview/{id}', [KepalaSekolahController::class, 'preview']);

    Route::get('/riwayat-surat', [KepalaSekolahController::class, 'riwayatSurat'])->name('kepsek.riwayat.surat');

    Route::get('/LihatDataPelanggaran', [KepalaSekolahController::class, 'show_lihat_data_pelanggaran'])->name('show_lihat_data_pelanggaran');

});











// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/Dashboard', [DashboardController::class, 'admin'])->name('admin');


// Route::get('/Dashboard|Admin', [HomeController::class, 'admin'])->name('admin-dashboard');