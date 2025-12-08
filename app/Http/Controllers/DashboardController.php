<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** * Karena kita menggunakan Livewire Full Page Component untuk Dashboard,
         * Sebenarnya Controller ini opsional jika route langsung ke Livewire.
         * Tapi jika Anda ingin me-return view wrapper, gunakan ini.
         */
        
        // Kita kembalikan view yang memuat komponen Livewire dashboard
        return view('dashboard');
    }
}