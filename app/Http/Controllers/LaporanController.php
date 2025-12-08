<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function logAktivitas()
    {
        return view('admin.laporan.log-aktivitas');
    }
    
    public function denda()
    {
        return view('admin.laporan.denda');
    }
}