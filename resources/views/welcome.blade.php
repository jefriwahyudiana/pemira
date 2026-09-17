@extends('layouts.app1')

@section('content')
<div class="min-h-screen bg-white text-slate-900">
    {{-- Navbar simpel --}}
    <nav class="max-w-6xl mx-auto px-4 py-5 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/pemira.png') }}" alt="Logo Pemira" class="w-11 h-11 rounded-full object-cover bg-blue-950 shadow">
            <span class="font-extrabold tracking-widest text-sm md:text-base text-blue-950">PEMIRA 2025</span>
        </a>
        <a href="/login" class="text-sm font-bold bg-blue-950 text-white px-5 py-2.5 rounded-full shadow hover:bg-blue-800 transition">Masuk</a>
    </nav>

    {{-- Hero --}}
    <header class="relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-orange-100 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-100 blur-3xl rounded-full"></div>

        <div class="relative max-w-6xl mx-auto px-4 pt-10 pb-16 md:pt-16 md:pb-24 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div class="text-center md:text-left">
                <span class="inline-block text-[11px] font-extrabold tracking-widest text-white bg-blue-950 px-4 py-1.5 rounded-full">PEMILIHAN UMUM RAYA 2025</span>
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mt-5 text-blue-950">
                    Satu Suara,<br>Masa Depan <span class="text-orange-500">Kampus</span>
                </h1>
                <p class="mt-5 text-base md:text-lg text-slate-600 leading-relaxed">
                    Gunakan hak pilihmu untuk Presiden Mahasiswa dan Ketua Himpunan Universitas Logistik dan Bisnis Internasional. Cepat, aman, dan transparan.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                    <a href="/login" class="text-center font-extrabold px-8 py-3.5 rounded-full bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-xl hover:scale-105 transition-all duration-300">Ayo Voting</a>
                    <a href="{{ route('hasilvote') }}" class="inline-flex items-center justify-center gap-2 text-center font-extrabold px-8 py-3.5 rounded-full bg-white border border-slate-200 text-blue-950 shadow hover:border-blue-300 transition-all duration-300">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                        </span>
                        Hasil Live
                    </a>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-orange-200 opacity-60 blur-3xl rounded-full scale-90"></div>
                    <img src="{{ asset('images/pemira.png') }}" alt="Logo Pemira" class="relative w-64 h-64 md:w-96 md:h-96 object-contain drop-shadow-2xl">
                </div>
            </div>
        </div>
    </header>

    <p class="text-center text-xs text-slate-400 pb-10">&copy; 2025 Pemira Universitas Logistik dan Bisnis Internasional</p>
</div>
@endsection
