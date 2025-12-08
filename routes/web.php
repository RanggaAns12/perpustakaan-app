<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- 1. Public & Auth (TETAP DI LUAR ADMIN) ---
use App\Livewire\LandingPage;
use App\Livewire\Auth\Login;

// --- 2. Admin Components (NAMESPACE BARU) ---

// Dashboard
use App\Livewire\Admin\Dashboard;

use App\Livewire\Admin\Setting\LandingPageSetting;
// Master Data
use App\Livewire\Admin\Master\KategoriIndex;
use App\Livewire\Admin\Master\KategoriCreate;
use App\Livewire\Admin\Master\KategoriEdit;

use App\Livewire\Admin\Master\PenerbitIndex;
use App\Livewire\Admin\Master\PenerbitCreate;
use App\Livewire\Admin\Master\PenerbitEdit;

use App\Livewire\Admin\Master\PenulisIndex;
use App\Livewire\Admin\Master\PenulisCreate;
use App\Livewire\Admin\Master\PenulisEdit;

use App\Livewire\Admin\Master\KelasIndex;
use App\Livewire\Admin\Master\KelasCreate;
use App\Livewire\Admin\Master\KelasEdit;

// Jurusan
use App\Livewire\Admin\Jurusan\JurusanIndex;
use App\Livewire\Admin\Jurusan\JurusanCreate;
use App\Livewire\Admin\Jurusan\JurusanEdit;

// Tahun Ajaran
use App\Livewire\Admin\TahunAjaran\TahunAjaranIndex;
use App\Livewire\Admin\TahunAjaran\TahunAjaranCreate;
use App\Livewire\Admin\TahunAjaran\TahunAjaranEdit;

// Manajemen Buku
use App\Livewire\Admin\Buku\BukuIndex;
use App\Livewire\Admin\Buku\BukuCreate;
use App\Livewire\Admin\Buku\BukuEdit;
use App\Livewire\Admin\Buku\BukuShow;

// Manajemen Siswa
use App\Livewire\Admin\Siswa\SiswaIndex;
use App\Livewire\Admin\Siswa\SiswaCreate;
use App\Livewire\Admin\Siswa\SiswaEdit;
use App\Livewire\Admin\Siswa\SiswaShow;

// Manajemen Guru
use App\Livewire\Admin\Guru\GuruIndex;
use App\Livewire\Admin\Guru\GuruCreate;
use App\Livewire\Admin\Guru\GuruEdit;

// Manajemen Pustakawan
use App\Livewire\Admin\Pustakawan\PustakawanIndex;
use App\Livewire\Admin\Pustakawan\PustakawanCreate;
use App\Livewire\Admin\Pustakawan\PustakawanEdit;

// Transaksi & Laporan
use App\Livewire\Admin\Peminjaman\PeminjamanIndex;
use App\Livewire\Admin\Peminjaman\PeminjamanCreate;
use App\Livewire\Admin\Peminjaman\PeminjamanShow;
use App\Livewire\Admin\Laporan\LaporanIndex;

//Pustakawan Routes
use App\Livewire\Pustakawan\Dashboard as PustakawanDashboard;
use App\Livewire\Pustakawan\SirkulasiIndex;
use App\Livewire\Pustakawan\BukuList;
use App\Livewire\Pustakawan\Profile; // Import class

//Guru Routes
use App\Livewire\Guru\Dashboard as GuruDashboard;
use App\Livewire\Guru\BukuList as GuruBukuList;
use App\Livewire\Guru\Profile as GuruProfile;

//siswa Routes
use App\Livewire\Siswa\Dashboard as SiswaDashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Public Routes
Route::get('/', LandingPage::class)->name('home');

// 2. Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// 3. Authenticated Routes (ADMIN AREA)
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // --- MODULE: Master Data ---
    Route::prefix('master')->group(function () {
        Route::get('/kategori', KategoriIndex::class)->name('kategori.index');
        Route::get('/kategori/create', KategoriCreate::class)->name('kategori.create');
        Route::get('/kategori/{kategori}/edit', KategoriEdit::class)->name('kategori.edit');

        Route::get('/penerbit', PenerbitIndex::class)->name('penerbit.index');
        Route::get('/penerbit/create', PenerbitCreate::class)->name('penerbit.create');
        Route::get('/penerbit/{penerbit}/edit', PenerbitEdit::class)->name('penerbit.edit');

        Route::get('/penulis', PenulisIndex::class)->name('penulis.index');
        Route::get('/penulis/create', PenulisCreate::class)->name('penulis.create');
        Route::get('/penulis/{penulis}/edit', PenulisEdit::class)->name('penulis.edit');

        Route::get('/kelas', KelasIndex::class)->name('kelas.index');
        Route::get('/kelas/create', KelasCreate::class)->name('kelas.create');
        Route::get('/kelas/{kelas}/edit', KelasEdit::class)->name('kelas.edit');

        Route::get('/jurusan', JurusanIndex::class)->name('jurusan.index');
        Route::get('/jurusan/create', JurusanCreate::class)->name('jurusan.create');
        Route::get('/jurusan/{jurusan}/edit', JurusanEdit::class)->name('jurusan.edit');

        Route::get('/tahun-ajaran', TahunAjaranIndex::class)->name('tahun-ajaran.index');
        Route::get('/tahun-ajaran/create', TahunAjaranCreate::class)->name('tahun-ajaran.create');
        Route::get('/tahun-ajaran/{tahun}/edit', TahunAjaranEdit::class)->name('tahun-ajaran.edit');
        Route::get('/pengaturan/landing-page', LandingPageSetting::class)->name('setting.landing-page');
    });

    // --- MODULE: Manajemen Buku ---
    Route::get('/buku', BukuIndex::class)->name('buku.index');
    Route::get('/buku/create', BukuCreate::class)->name('buku.create');
    Route::get('/buku/{buku}', BukuShow::class)->name('buku.show');
    Route::get('/buku/{buku}/edit', BukuEdit::class)->name('buku.edit');

    // --- MODULE: Manajemen Siswa ---
    Route::get('/siswa', SiswaIndex::class)->name('siswa.index');
    Route::get('/siswa/create', SiswaCreate::class)->name('siswa.create');
    Route::get('/siswa/{siswa}', SiswaShow::class)->name('siswa.show');
    Route::get('/siswa/{siswa}/edit', SiswaEdit::class)->name('siswa.edit');

    // --- MODULE: Manajemen Guru ---
    Route::get('/guru', GuruIndex::class)->name('guru.index');
    Route::get('/guru/create', GuruCreate::class)->name('guru.create');
    Route::get('/guru/{guru}/edit', GuruEdit::class)->name('guru.edit');

    // --- MODULE: Manajemen Pustakawan ---
    Route::get('/pustakawan', PustakawanIndex::class)->name('pustakawan.index');
    Route::get('/pustakawan/create', PustakawanCreate::class)->name('pustakawan.create');
    Route::get('/pustakawan/{pustakawan}/edit', PustakawanEdit::class)->name('pustakawan.edit');

    // --- MODULE: Transaksi Peminjaman ---
    Route::get('/peminjaman', PeminjamanIndex::class)->name('peminjaman.index');
    Route::get('/peminjaman/create', PeminjamanCreate::class)->name('peminjaman.create');
    Route::get('/peminjaman/{peminjaman}', PeminjamanShow::class)->name('peminjaman.show');

    // --- MODULE: Laporan ---
    Route::get('/laporan', LaporanIndex::class)->name('laporan.index');
    Route::get('/laporan/aktivitas', LaporanIndex::class)->name('laporan.aktivitas'); 


    Route::middleware(['auth', 'role:Pustakawan'])->prefix('pustakawan')->group(function () {
        // Dashboard
        Route::get('/dashboard', PustakawanDashboard::class)->name('pustakawan.dashboard');
        // Sirkulasi
        Route::get('/sirkulasi', SirkulasiIndex::class)->name('pustakawan.sirkulasi');
        // Create Transaksi (Menggunakan Logic Admin, tapi diakses Pustakawan)
        Route::get('/transaksi/baru', PeminjamanCreate::class)->name('pustakawan.transaksi.create');
        // Katalog Buku (Read Only)
        Route::get('/buku', BukuList::class)->name('pustakawan.buku');
        // Route Profil
        Route::get('/profile', Profile::class)->name('pustakawan.profile');
    });

    Route::middleware(['auth', 'role:Guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', GuruDashboard::class)->name('guru.dashboard');
        Route::get('/katalog-buku', GuruBukuList::class)->name('guru.buku');
        Route::get('/profil', GuruProfile::class)->name('guru.profile');
    });

    Route::middleware(['auth', 'role:Siswa'])->prefix('siswa')->group(function () {
        // Route ini menggunakan layout 'components.layouts.siswa' (tanpa sidebar)
        // karena sudah didefinisikan di dalam Class Component-nya
        Route::get('/dashboard', SiswaDashboard::class)->name('siswa.dashboard');
    });

});