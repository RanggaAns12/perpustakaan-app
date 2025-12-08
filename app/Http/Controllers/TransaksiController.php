<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // --- Peminjaman ---

    public function indexPeminjaman()
    {
        return view('admin.transaksi.peminjaman.index');
    }

    public function createPeminjaman()
    {
        return view('admin.transaksi.peminjaman.create');
    }

    public function showPeminjaman(Peminjaman $peminjaman)
    {
        return view('admin.transaksi.peminjaman.show', compact('peminjaman'));
    }

    // --- Pengembalian ---

    public function indexPengembalian()
    {
        return view('admin.transaksi.pengembalian.index');
    }

    public function createPengembalian()
    {
        return view('admin.transaksi.pengembalian.create');
    }
}