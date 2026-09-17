@extends('layouts.app')

@section('content')
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden">
        <div class="bg-blue-950 px-8 pt-8 pb-6 text-center relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-500 opacity-20 blur-3xl rounded-full"></div>
            <img src="{{ asset('images/pemira.png') }}" alt="Logo Pemira" class="relative w-20 h-20 mx-auto rounded-full object-cover bg-white shadow-lg">
            <h2 class="relative text-2xl font-extrabold text-white mt-4">LOGIN <span class="text-orange-400">PEMILIH</span></h2>
            <p class="relative text-xs tracking-widest text-blue-200 mt-1">PEMILIHAN UMUM RAYA 2025</p>
        </div>

        <form class="px-8 py-6 space-y-4" method="POST" action="{{ route('login') }}">
            @csrf
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3">{{ session('success') }}</div>
            @endif

            <div>
                <label for="npm" class="block text-sm font-bold text-slate-700 mb-1.5">NPM</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" /></svg>
                    </span>
                    <input type="text" id="npm" name="npm" value="{{ old('npm') }}" placeholder="Masukkan NPM" autocomplete="username"
                        class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl shadow-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" autocomplete="current-password"
                        class="w-full pl-11 pr-12 py-3 border border-slate-200 rounded-xl shadow-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition" aria-label="Tampilkan password">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.948 9.948 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full font-extrabold py-3 rounded-xl text-white bg-gradient-to-r from-orange-500 to-amber-500 shadow-lg hover:scale-[1.02] hover:shadow-xl transition-all duration-300">
                Masuk &amp; Voting
            </button>

            <p class="text-center text-sm text-slate-500 pt-1">
                <a href="{{ route('home') }}" class="font-semibold text-blue-900 hover:text-orange-500 transition">&larr; Kembali ke Beranda</a>
            </p>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const open = document.getElementById('eyeOpen');
            const closed = document.getElementById('eyeClosed');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            open.classList.toggle('hidden', !show);
            closed.classList.toggle('hidden', show);
        }
    </script>
@endsection
