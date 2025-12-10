<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- 1. Public & Auth ---
use App\Livewire\LandingPage;
use App\Livewire\Auth\Login;

// --- 2. Admin Components ---
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

// Pustakawan Routes
use App\Livewire\Pustakawan\Dashboard as PustakawanDashboard;
use App\Livewire\Pustakawan\SirkulasiIndex;
use App\Livewire\Pustakawan\BukuList;
use App\Livewire\Pustakawan\Profile;

// Guru Routes
use App\Livewire\Guru\Dashboard as GuruDashboard;
use App\Livewire\Guru\BukuList as GuruBukuList;
use App\Livewire\Guru\Profile as GuruProfile;

// Siswa Routes
use App\Livewire\Siswa\Dashboard as SiswaDashboard;
use App\Livewire\Siswa\KatalogBuku;       // <-- Pastikan ini di-import
use App\Livewire\Siswa\RiwayatPeminjaman; // <-- Pastikan ini di-import
use App\Livewire\Siswa\NotifikasiSiswa;

use App\Livewire\Chat\StaffChat;
use App\Livewire\Notifikasi\NotifikasiIndex;


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

// 3. Authenticated Routes
Route::middleware('auth')->group(function () {

    Route::get('/notifikasi', NotifikasiIndex::class)->name('notifikasi.index');
    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // =========================================================================
    // PERBAIKAN: ROUTES ROLE KHUSUS DIPINDAHKAN KE ATAS (SEBELUM ADMIN)
    // =========================================================================

    // --- Role: SISWA ---
    // Dipindah ke sini agar URL '/siswa/dashboard' tidak dianggap sebagai ID '/siswa/{id}' oleh Admin
    Route::middleware(['role:Siswa'])->prefix('siswa')->group(function () {
        Route::get('/dashboard', SiswaDashboard::class)->name('siswa.dashboard');
        Route::get('/katalog', \App\Livewire\Siswa\KatalogBuku::class)->name('siswa.katalog');
        Route::get('/riwayat', \App\Livewire\Siswa\RiwayatPeminjaman::class)->name('siswa.riwayat');
        Route::get('/peminjaman/create/{buku}', \App\Livewire\Siswa\PeminjamanCreate::class)->name('siswa.peminjaman.create');
        Route::get('/siswa/notifikasi', NotifikasiSiswa::class)->name('siswa.notifikasi');
    });

    // --- Role: PUSTAKAWAN ---
    Route::middleware(['role:Pustakawan'])->prefix('pustakawan')->group(function () {
        Route::get('/dashboard', PustakawanDashboard::class)->name('pustakawan.dashboard');
        Route::get('/sirkulasi', SirkulasiIndex::class)->name('pustakawan.sirkulasi');
        Route::get('/transaksi/baru', PeminjamanCreate::class)->name('pustakawan.transaksi.create');
        Route::get('/buku', BukuList::class)->name('pustakawan.buku');
        Route::get('/profile', Profile::class)->name('pustakawan.profile');
    });


    Route::middleware(['auth', 'role:Admin,Pustakawan'])->group(function () {
        // Route untuk Admin/Pustakawan membalas pesan
        Route::get('/pesan-masuk', StaffChat::class)->name('chat.index');
    });

    // --- Role: GURU ---
    Route::middleware(['role:Guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', GuruDashboard::class)->name('guru.dashboard');
        Route::get('/katalog-buku', GuruBukuList::class)->name('guru.buku');
        Route::get('/profil', GuruProfile::class)->name('guru.profile');
    });

    // =========================================================================
    // AREA ADMIN (Route Wildcard ada di bawah sini)
    // =========================================================================

    // Dashboard Admin
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
        Route::get('/admin/setting/galeri', \App\Livewire\Admin\Setting\GaleriManager::class)->name('setting.galeri');
    });

    Route::prefix('pengguna')->group(function () {
        Route::get('/admin', \App\Livewire\Admin\Pengguna\AdminIndex::class)->name('admin.index');
        Route::get('/admin/create', \App\Livewire\Admin\Pengguna\AdminCreate::class)->name('admin.create');
        
        // Route Edit (Tambahan Baru)
        Route::get('/admin/{id}/edit', \App\Livewire\Admin\Pengguna\AdminEdit::class)->name('admin.edit');
    });

    // --- MODULE: Manajemen Buku ---
    Route::get('/buku', BukuIndex::class)->name('buku.index');
    Route::get('/buku/create', BukuCreate::class)->name('buku.create');
    Route::get('/buku/{buku}', BukuShow::class)->name('buku.show');
    Route::get('/buku/{buku}/edit', BukuEdit::class)->name('buku.edit');

    // --- MODULE: Manajemen Siswa (ADMIN) ---
    // Note: Route ini memiliki wildcard {siswa}, jadi harus diletakkan SETELAH route khusus siswa di atas.
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
});