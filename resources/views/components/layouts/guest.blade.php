<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Perpustakaan Digital' }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Animasi AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- CSS --}}
    <style>
        @import "tailwindcss";
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-pattern {
            background-image: radial-gradient(#4F46E5 0.5px, transparent 0.5px), radial-gradient(#4F46E5 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.1;
        }
    </style>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Stack Styles untuk Halaman Khusus --}}
    @stack('styles')
</head>
<body class="font-sans text-slate-900 antialiased bg-slate-50 relative overflow-x-hidden min-h-screen flex flex-col">

    {{-- Background Animasi (Global) --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-pattern z-0"></div>
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-indigo-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-purple-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[500px] h-[500px] bg-blue-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob animation-delay-4000"></div>
    </div>

    {{-- Slot Konten Utama --}}
    <div class="relative z-10 w-full flex-grow">
        {{ $slot }}
    </div>

    {{-- Footer Default (Jika diperlukan, bisa di-override di halaman) --}}
    @if(!request()->routeIs('landing'))
    <div class="relative z-10 w-full text-center py-6 text-xs text-slate-400 font-medium">
        &copy; {{ date('Y') }} SMA Negeri 1 Tanjung Morawa.
    </div>
    @endif

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
        });
    </script>
    
    {{-- Stack Scripts --}}
    @stack('scripts')
</body>
</html>