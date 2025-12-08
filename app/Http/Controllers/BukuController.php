<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Tampilkan daftar buku.
     */
    public function index()
    {
        // Return view yang berisi Livewire Table Buku
        return view('admin.buku.index');
    }

    /**
     * Tampilkan form tambah buku.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Tampilkan form edit buku.
     */
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }
    
    /**
     * Halaman Detail Buku (Bisa diakses Siswa juga).
     */
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }
}