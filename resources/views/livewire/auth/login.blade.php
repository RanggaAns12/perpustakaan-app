<div>
    {{-- Load CSS Utama & JS Khusus Login --}}
    @vite(['resources/css/app.css', 'resources/js/login.js'])

    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4 relative overflow-hidden">
        
        {{-- 1. Animasi Background (Blob Effect) --}}
        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

        {{-- 2. Kartu Login (Glassmorphism) --}}
        {{-- x-data="loginForm" berasal dari file resources/js/login.js --}}
        <div x-data="loginForm" 
             class="relative w-full max-w-md glass-card rounded-2xl p-8 sm:p-10 transform transition-all duration-500 hover:scale-[1.01]">
            
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="text-center mb-8">
                {{-- PERUBAHAN: Logo Image Menggantikan Icon --}}
                <div class="flex justify-center mb-6">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" 
                         alt="Logo Aplikasi" 
                         class="h-24 w-auto object-contain drop-shadow-md transition-transform duration-300 hover:scale-105">
                </div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">SMA Negeri 1 Tanjung Morawa</h1>
                <p class="text-sm text-gray-500 mt-2">Perpustakaan Online</p>
            </div>

            {{-- Form Login --}}
            <form wire:submit="login" @submit="submitForm" class="space-y-6">
                
                {{-- Input Username --}}
                <div class="relative group">
                    {{-- PENTING: Class 'peer' wajib ada di sini agar label bisa bergerak --}}
                    <input type="text" 
                           id="username" 
                           wire:model="username" 
                           class="input-field peer" 
                           placeholder=" " 
                           required />
                    
                    <label for="username" class="input-label">
                        Username
                    </label>
                    
                    {{-- Icon User --}}
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 peer-focus:text-indigo-600 transition-colors">
                        <x-heroicon-o-user class="w-5 h-5" />
                    </div>
                    
                    {{-- Error Message --}}
                    @error('username') 
                        <span class="text-red-500 text-xs mt-1 block animate-pulse">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Input Password --}}
                <div class="relative group">
                    {{-- PENTING: Class 'peer' wajib ada di sini --}}
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           wire:model="password" 
                           class="input-field peer" 
                           placeholder=" " 
                           required />
                    
                    <label for="password" class="input-label">
                        Password
                    </label>
                    
                    {{-- Tombol Show/Hide Password --}}
                    <button type="button" 
                            @click="togglePassword" 
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-indigo-600 cursor-pointer focus:outline-none transition-colors">
                        <x-heroicon-o-eye x-show="!showPassword" class="w-5 h-5" />
                        <x-heroicon-o-eye-slash x-show="showPassword" class="w-5 h-5" x-cloak />
                    </button>

                    {{-- Error Message --}}
                    @error('password') 
                        <span class="text-red-500 text-xs mt-1 block animate-pulse">{{ $message }}</span> 
                    @enderror
                </div>

                {{-- Remember Me & Forgot PW --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition">
                        <span class="text-gray-600 group-hover:text-indigo-600 transition">Ingat saya</span>
                    </label>
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline transition">
                        Lupa password?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    
                    {{-- Loading Spinner --}}
                    <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <span wire:loading.remove>Masuk Akun</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Belum punya akun? 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition">Hubungi Admin</a>
                </p>
            </div>
        </div>
    </div>
</div>