@extends('layouts.app1')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-orange-50 via-white to-blue-50 pb-16">
    <div class="max-w-5xl mx-auto px-4 pt-8">
        {{-- Header --}}
        <a href="{{ route('menuvote', ['prodi' => Session::get('prodi')]) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-900 hover:text-orange-500 transition">&larr; Kembali ke Menu Vote</a>

        <div class="text-center mt-6 mb-10">
            <span class="inline-block text-[11px] font-extrabold tracking-widest text-white bg-blue-950 px-4 py-1.5 rounded-full uppercase">{{ $jenis_pemilihan }}</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-950 mt-4">
                @if ($jenis_pemilihan === 'presma')
                    Pilih Presiden Mahasiswa
                @else
                    Pilih Ketua {{ strtoupper($jenis_pemilihan) }}
                @endif
            </h1>
            <p class="text-slate-500 mt-2">Pelajari profil tiap paslon, lalu tentukan pilihanmu &bull; {{ $dataPaslon->count() }} paslon</p>
        </div>

        {{-- Kartu paslon --}}
        <div class="flex flex-col gap-8">
            @foreach ($dataPaslon as $paslon)
                @php
                    $adaWakil = trim((string) $paslon->nm_wakil) !== '';
                    $ftKetua = $paslon->ft_ketua ? asset('storage/' . ltrim($paslon->ft_ketua, '/')) : asset('images/pemira.png');
                    $ftWakil = $paslon->ft_wakil ? asset('storage/' . ltrim($paslon->ft_wakil, '/')) : asset('images/pemira.png');
                @endphp
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                    <div class="bg-blue-950 px-6 py-4 flex items-center justify-between">
                        <span class="text-white font-extrabold tracking-wide">PASLON {{ $paslon->paslon_ke }}</span>
                        <span class="text-[11px] font-bold text-amber-300 uppercase tracking-widest">{{ $jenis_pemilihan }}</span>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 {{ $adaWakil ? '' : 'sm:max-w-xs sm:mx-auto' }}">
                            <div class="text-center">
                                <img src="{{ $ftKetua }}" alt="Foto {{ $paslon->nm_ketua }}" class="w-44 h-44 md:w-56 md:h-56 mx-auto rounded-2xl object-cover shadow-lg">
                                <p class="text-[11px] font-bold text-orange-500 uppercase tracking-widest mt-3">{{ $paslon->jbt_ketua }}</p>
                                <p class="text-lg font-extrabold text-slate-900">{{ $paslon->nm_ketua }}</p>
                                <p class="text-xs text-slate-500">{{ $paslon->pd_ketua }} &bull; {{ $paslon->ang_ketua }}</p>
                            </div>
                            @if ($adaWakil)
                                <div class="text-center">
                                    <img src="{{ $ftWakil }}" alt="Foto {{ $paslon->nm_wakil }}" class="w-44 h-44 md:w-56 md:h-56 mx-auto rounded-2xl object-cover shadow-lg">
                                    <p class="text-[11px] font-bold text-orange-500 uppercase tracking-widest mt-3">{{ $paslon->jbt_wakil }}</p>
                                    <p class="text-lg font-extrabold text-slate-900">{{ $paslon->nm_wakil }}</p>
                                    <p class="text-xs text-slate-500">{{ $paslon->pd_wakil }} &bull; {{ $paslon->ang_wakil }}</p>
                                </div>
                            @endif
                        </div>

                        <details class="mt-6 group">
                            <summary class="cursor-pointer list-none flex items-center justify-between bg-slate-50 hover:bg-slate-100 transition rounded-2xl px-5 py-3.5 font-bold text-blue-950">
                                <span>Visi &amp; Misi</span>
                                <span class="text-orange-500 group-open:rotate-180 transition-transform">&#9660;</span>
                            </summary>
                            <div class="px-2 pt-4 space-y-4">
                                <div class="border-l-4 border-blue-600 bg-blue-50/60 rounded-r-2xl p-4">
                                    <p class="font-bold text-blue-950 text-sm">Visi</p>
                                    <p class="text-sm text-slate-600 mt-1 whitespace-pre-line">{{ $paslon->visi }}</p>
                                </div>
                                <div class="border-l-4 border-orange-500 bg-orange-50/60 rounded-r-2xl p-4">
                                    <p class="font-bold text-blue-950 text-sm">Misi</p>
                                    <p class="text-sm text-slate-600 mt-1 whitespace-pre-line">{{ $paslon->misi }}</p>
                                </div>
                            </div>
                        </details>

                        <button onclick="confirmVote({{ $paslon->id }}, '{{ addslashes($paslon->nm_ketua) }}{{ $adaWakil ? ' & ' . addslashes($paslon->nm_wakil) : '' }}')"
                            class="mt-6 w-full font-extrabold py-3.5 rounded-2xl text-white bg-gradient-to-r from-orange-500 to-amber-500 shadow-lg hover:scale-[1.01] hover:shadow-xl transition-all duration-300">
                            Vote Paslon {{ $paslon->paslon_ke }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-center text-xs text-slate-400 mt-10">Suaramu menentukan masa depan kampus &bull; Satu akun satu suara</p>
    </div>
</div>

{{-- Form vote tunggal --}}
<form method="POST" action="{{ route('vote.add', ['npm' => Session::get('npm')]) }}" id="voteForm" class="hidden">
    @csrf
    <input type="hidden" name="paslon_id" id="votePaslonId" value="">
    <input type="hidden" name="jenis_vote" value="{{ $jenis_pemilihan }}">
</form>

{{-- Modal konfirmasi --}}
<div id="confirmModal" class="fixed inset-0 bg-slate-900/60 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 md:p-8 text-center">
        <div class="w-14 h-14 mx-auto rounded-full bg-orange-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <h3 class="text-xl font-extrabold text-blue-950 mt-4">Yakin dengan pilihanmu?</h3>
        <p class="text-sm text-slate-500 mt-2">Kamu memilih <span id="confirmName" class="font-bold text-slate-800"></span>. Suara tidak dapat diubah setelah dikirim.</p>
        <div class="grid grid-cols-2 gap-3 mt-6">
            <button onclick="closeConfirmModal()" class="font-bold py-3 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Batal</button>
            <button onclick="submitVote()" class="font-extrabold py-3 rounded-2xl text-white bg-gradient-to-r from-orange-500 to-amber-500 shadow hover:scale-[1.02] transition">Ya, Vote!</button>
        </div>
    </div>
</div>

@if (session('error'))
    <div id="errorModal" class="fixed inset-0 bg-slate-900/60 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6 md:p-8 text-center">
            <h3 class="text-xl font-extrabold text-red-600">Terjadi Kesalahan</h3>
            <p class="text-sm text-slate-600 mt-3">{{ session('error') }}</p>
            <button onclick="closeModalError()" class="mt-6 w-full font-bold py-3 rounded-2xl bg-red-500 text-white hover:bg-red-600 transition">Tutup</button>
        </div>
    </div>
@endif

<script>
    function confirmVote(paslonId, nama) {
        document.getElementById('votePaslonId').value = paslonId;
        document.getElementById('confirmName').textContent = nama;
        const modal = document.getElementById('confirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function submitVote() {
        document.getElementById('voteForm').submit();
    }

    function closeModalError() {
        document.getElementById('errorModal').classList.add('hidden');
    }
</script>
@endsection
