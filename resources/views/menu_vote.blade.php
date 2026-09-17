@extends('layouts.app')

@section('content')
    <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-3 gap-5 px-4 py-8 items-start">
    <div class="lg:col-span-2 flex flex-col gap-5 min-w-0">
        @if (session('success'))
            <div class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold rounded-xl px-4 py-3 shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kartu sapaan --}}
        @php
            $initials = strtoupper(implode('', array_slice(array_map(fn ($w) => mb_substr($w, 0, 1), preg_split('/\s+/', trim($nama ?? 'P'))), 0, 2)));
        @endphp
        <div class="relative w-full bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 shadow-[4.0px_8.0px_8.0px_rgba(0,0,0,0.38)] rounded-2xl p-6 overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-orange-500 opacity-25 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-14 -left-14 w-56 h-56 bg-blue-500 opacity-25 blur-3xl rounded-full"></div>
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 via-amber-400 to-orange-500"></div>
            <div class="relative flex items-center gap-4">
                <div class="shrink-0 w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white text-xl font-extrabold shadow-lg">{{ $initials }}</div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs tracking-widest text-orange-300 font-bold">PEMILIHAN UMUM RAYA 2025</p>
                    <h2 class="text-2xl font-extrabold text-white truncate leading-tight">{{ $nama ?? 'Pemilih' }}</h2>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="text-[11px] font-bold text-blue-100 bg-white/10 px-2.5 py-1 rounded-full">{{ $npm ?? '-' }}</span>
                        <span class="text-[11px] font-bold text-blue-100 bg-white/10 px-2.5 py-1 rounded-full">{{ $prodi }}</span>
                    </div>
                </div>
                <a href="{{ route('logout') }}" title="Keluar" class="shrink-0 w-10 h-10 flex items-center justify-center rounded-full text-white bg-white/10 border border-white/20 hover:bg-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                </a>
            </div>
        </div>

        {{-- Kartu-kartu vote (komponen asli, tidak diubah) --}}
        <div class="w-full space-y-8">
            @include('presma.presma')

            @if ($prodi == 'D3 Teknik Informatika' || $prodi == 'D4 Teknik Informatika')
                @include('hima.himatif')
            @elseif ($prodi == 'S1 Manajemen Logistik')
                @include('hima.himagis')
            @elseif ($prodi == 'D3 Administrasi Logistik' || $prodi == 'D4 Logistik Bisnis')
                @include('hima.himalogbis')
            @elseif ($prodi == 'S1 Manajemen Transportasi')
                @include('hima.himaporta')
            @elseif ($prodi == 'D3 Manajemen Pemasaran' || $prodi == 'D4 Manajemen Perusahaan' )
                @include('hima.himanbis')
            @elseif ($prodi == 'D3 Akuntansi' || $prodi == 'D4 Akuntansi Keuangan')
                @include('hima.hma')
            @elseif ($prodi == 'S1 Sains Data')
                @include('hima.himasta')
            @elseif ($prodi == 'D3 Manajemen Informatika')
                @include('hima.hmmi')
            @endif
        </div>
    </div>

    {{-- Panel samping --}}
    <aside class="flex flex-col gap-5 min-w-0 lg:sticky lg:top-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="font-extrabold text-blue-950">Cara Memilih</h3>
            <ol class="mt-4 space-y-4">
                <li class="flex gap-3">
                    <span class="shrink-0 w-7 h-7 rounded-full bg-blue-950 text-white text-sm font-extrabold flex items-center justify-center">1</span>
                    <p class="text-sm text-slate-600">Klik <span class="font-bold text-slate-800">Vote Sekarang</span> pada pemilihan yang ingin diikuti.</p>
                </li>
                <li class="flex gap-3">
                    <span class="shrink-0 w-7 h-7 rounded-full bg-blue-950 text-white text-sm font-extrabold flex items-center justify-center">2</span>
                    <p class="text-sm text-slate-600">Pelajari profil, visi, dan misi paslon lewat tombol <span class="font-bold text-slate-800">Detail Profil</span>.</p>
                </li>
                <li class="flex gap-3">
                    <span class="shrink-0 w-7 h-7 rounded-full bg-orange-500 text-white text-sm font-extrabold flex items-center justify-center">3</span>
                    <p class="text-sm text-slate-600">Klik <span class="font-bold text-slate-800">Vote Paslon</span> lalu konfirmasi pilihanmu.</p>
                </li>
            </ol>
        </div>

        <div class="relative overflow-hidden rounded-2xl shadow-lg p-6 bg-gradient-to-br from-blue-950 to-slate-900 text-white">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-500 opacity-25 blur-3xl rounded-full"></div>
            <div class="relative">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                    </span>
                    <h3 class="font-extrabold">Hasil Live</h3>
                </div>
                <p class="text-sm text-blue-100/80 mt-2">Pantau perolehan suara Presma dan Hima secara real-time.</p>
                <a href="{{ route('hasilvote') }}" class="inline-block mt-4 text-sm font-extrabold px-5 py-2.5 rounded-full bg-gradient-to-r from-orange-500 to-amber-500 shadow hover:scale-105 transition-all duration-300">Lihat Hasil</a>
            </div>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
            <p class="text-sm font-bold text-amber-800">Pilih dengan bijak</p>
            <p class="text-xs text-amber-700 mt-1">Suaramu menentukan masa depan kampus. Satu akun hanya dapat memilih satu kali di tiap pemilihan.</p>
        </div>
    </aside>
    </div>
     <!-- Modal Error -->
     @if (session('error'))
     <div id="errorModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
             <!-- Header -->
             <div class="flex justify-between items-center border-b pb-3">
                 <h3 class="text-lg font-semibold text-red-600">Kesalahan</h3>
                 <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>

             <!-- Body -->
             <div class="mt-4 text-gray-700">
                 <p>{{ session('error') }}</p>
             </div>

             <!-- Footer -->
             <div class="mt-6 flex justify-end">
                 <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                     Tutup
                 </button>
             </div>
         </div>
     </div>
     @endif
@endsection

@push('js')
    <!-- Script Modal -->
    <script>
        function closeModal() {
            document.getElementById('errorModal').classList.add('hidden');
        }
    </script>
@endpush
