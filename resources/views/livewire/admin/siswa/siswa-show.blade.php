<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap data siswa.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
            </a>
            <a href="{{ route('siswa.edit', $siswa->siswa_id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl text-sm font-medium hover:bg-yellow-100 transition shadow-sm">
                <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" /> Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Kolom Kiri: Profil Singkat --}}
        <div class="space-y-6">
            {{-- Card Profil --}}
            <div class="bg-white rounded-2xl shadow-lg shadow-indigo-100 border border-white overflow-hidden relative">
                <div class="h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                <div class="px-6 pb-6 text-center relative">
                    <div class="relative w-32 h-32 mx-auto -mt-16 bg-white rounded-full p-1 shadow-lg">
                        <div class="w-full h-full rounded-full overflow-hidden bg-gray-100">
                            @if($siswa->foto_profil)
                                <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 font-bold text-4xl">
                                    {{ substr($siswa->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $siswa->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-500">{{ $siswa->nis }}</p>
                    
                    <div class="mt-4 flex justify-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $siswa->status_siswa == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            <span class="w-2 h-2 rounded-full {{ $siswa->status_siswa == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} mr-2"></span>
                            {{ $siswa->status_siswa }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Informasi Akun</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Username</span>
                        <span class="font-mono font-medium text-gray-900">{{ $siswa->user->username ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Email</span>
                        <span class="font-medium text-gray-900">{{ $siswa->user->email ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Terdaftar</span>
                        <span class="font-medium text-gray-900">{{ $siswa->tanggal_daftar ? \Carbon\Carbon::parse($siswa->tanggal_daftar)->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Lengkap --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Akademik --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <x-heroicon-o-academic-cap class="w-5 h-5 text-indigo-600" />
                    Data Akademik
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Kelas</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Jurusan</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Wali Kelas</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->kelas->waliKelas->nama_lengkap ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Tahun Ajaran</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->kelas->tahunAjaran->tahun_ajaran ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Biodata --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <x-heroicon-o-identification class="w-5 h-5 text-indigo-600" />
                    Biodata Diri
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Tempat, Tanggal Lahir</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $siswa->tempat_lahir ?? '-' }}, 
                            {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Jenis Kelamin</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs text-gray-400 uppercase font-semibold">Alamat Lengkap</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <x-heroicon-o-phone class="w-5 h-5 text-indigo-600" />
                    Kontak & Wali
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">No. HP Siswa</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->nomor_telepon ?? '-' }}</p>
                    </div>
                    <div></div> {{-- Spacer --}}
                    
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Nama Orang Tua / Wali</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->nama_orangtua ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">No. HP Orang Tua</p>
                        <p class="text-base font-medium text-gray-900">{{ $siswa->telepon_orangtua ?? '-' }}</p>
                    </div>