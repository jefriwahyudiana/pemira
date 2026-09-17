@extends('layouts.app1')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-orange-200 to-blue-200 pb-16">
    <div class="max-w-6xl mx-auto px-4 pt-10">

        {{-- ===== HERO PRESMA ===== --}}
        <div class="relative overflow-hidden rounded-3xl shadow-2xl bg-gradient-to-br from-gray-900 via-blue-950 to-black p-6 md:p-10 mb-8">
            <div class="absolute -top-16 -left-16 w-80 h-80 bg-blue-600 opacity-20 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-16 -right-16 w-80 h-80 bg-orange-500 opacity-20 blur-3xl rounded-full"></div>

            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-wide uppercase">Presma Kema ULBI</h1>
                        <span class="inline-flex items-center gap-2 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                            </span>
                            LIVE
                        </span>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Hasil diperbarui otomatis &bull; Terakhir: <span id="stat-updated">{{ $diperbarui }}</span></p>
                </div>
                <a href="{{ route('home') }}" class="shrink-0 text-center text-white font-bold py-2.5 px-6 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 shadow-lg hover:scale-105 transition-all duration-300">Kembali</a>
            </div>

            <div class="relative grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 text-center">
                    <p id="stat-dpt" class="text-3xl font-extrabold text-white">{{ number_format($totalPemilih) }}</p>
                    <p class="text-xs text-gray-300 uppercase tracking-widest mt-1">Total DPT</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 text-center">
                    <p id="stat-presma" class="text-3xl font-extrabold text-blue-400">{{ number_format($suaraPresma) }}</p>
                    <p class="text-xs text-gray-300 uppercase tracking-widest mt-1">Suara Masuk</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 text-center">
                    <p id="stat-partisipasi" class="text-3xl font-extrabold text-emerald-400">{{ $partisipasi }}%</p>
                    <p class="text-xs text-gray-300 uppercase tracking-widest mt-1">Partisipasi</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-4 text-center">
                    <p id="stat-belum" class="text-3xl font-extrabold text-gray-300">{{ number_format($belumMemilih) }}</p>
                    <p class="text-xs text-gray-300 uppercase tracking-widest mt-1">Belum Memilih</p>
                </div>
            </div>

            <div id="presma-duel" class="relative grid grid-cols-1 md:grid-cols-2 gap-6 mt-8"></div>

            <div class="relative mt-6 bg-white/5 border border-white/10 rounded-2xl p-4 md:p-6">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-widest mb-3">Perbandingan Suara</p>
                <div class="h-[260px] md:h-[300px]"><canvas id="presma-chart"></canvas></div>
            </div>
        </div>

        {{-- ===== CAROUSEL HIMA ===== --}}
        <div class="flex items-center justify-between mb-4 px-1">
            <h2 class="text-2xl font-extrabold text-blue-950 tracking-wide uppercase">Hasil <span class="text-orange-500">Himpunan</span></h2>
            <span class="text-xs font-semibold text-slate-500 bg-white px-3 py-1.5 rounded-full shadow">Geser otomatis tiap 10 detik</span>
        </div>

        <div id="hima-carousel" class="relative">
            <div class="overflow-hidden rounded-3xl">
                <div id="hima-track" class="flex transition-transform duration-700 ease-in-out">
                    @foreach ($hima as $gi => $group)
                        <div class="w-full shrink-0 px-0.5">
                            <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl md:text-2xl font-extrabold text-blue-950 uppercase">{{ $group['jenis'] }}</h3>
                                    <span class="text-sm font-bold text-orange-600 bg-orange-100 px-3 py-1 rounded-full" id="hima-total-{{ $gi }}">{{ number_format($group['total']) }} suara</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                    <div class="h-64 md:h-72"><canvas id="hima-chart-{{ $gi }}"></canvas></div>
                                    <div id="hima-legend-{{ $gi }}" class="flex flex-col gap-3"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button id="hima-prev" aria-label="Sebelumnya" class="absolute top-1/2 -translate-y-1/2 -left-3 md:-left-5 w-10 h-10 rounded-full bg-white shadow-xl text-blue-950 font-extrabold hover:scale-110 transition">&#10094;</button>
            <button id="hima-next" aria-label="Berikutnya" class="absolute top-1/2 -translate-y-1/2 -right-3 md:-right-5 w-10 h-10 rounded-full bg-white shadow-xl text-blue-950 font-extrabold hover:scale-110 transition">&#10095;</button>
            <div id="hima-dots" class="flex justify-center gap-2 mt-5"></div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script>
(function () {
    Chart.register(ChartDataLabels);

    const PALETTE = ['#2563eb', '#f97316', '#10b981', '#a855f7', '#eab308', '#ec4899', '#14b8a6', '#f43f5e'];
    const DATA_URL = @json(route('hasilvote.data'));
    let state = @json(['presma' => $presma, 'hima' => $hima]);
    let slide = 0;
    let slideTimer = null;
    let pollTimer = null;
    const himaCharts = [];
    let presmaChart = null;

    const centerText = {
        id: 'centerText',
        afterDraw(chart, args, opts) {
            if (!opts || !opts.lines) return;
            const ctx = chart.ctx;
            const meta = chart.getDatasetMeta(0);
            if (!meta.data[0]) return;
            const x = meta.data[0].x, y = meta.data[0].y;
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#0f172a';
            ctx.font = '800 26px Arial';
            ctx.fillText(opts.lines[0] || '', x, y - 10);
            ctx.font = '600 12px Arial';
            ctx.fillStyle = '#64748b';
            ctx.fillText(opts.lines[1] || '', x, y + 14);
            ctx.restore();
        }
    };

    function num(n) { return Number(n || 0).toLocaleString('id-ID'); }

    function hasWakil(p) { return p.nm_wakil && String(p.nm_wakil).trim() !== ''; }

    function pasanganName(p) { return hasWakil(p) ? p.nm_ketua + ' &amp; ' + p.nm_wakil : p.nm_ketua; }

    function fotoPair(p, size, border) {
        return '<div class="flex -space-x-4 shrink-0">' +
            '<img src="' + p.ft_ketua + '" alt="Foto ketua" class="relative z-10 ' + size + ' rounded-full object-cover border-2 ' + border + '">' +
            (hasWakil(p) ? '<img src="' + p.ft_wakil + '" alt="Foto wakil" class="' + size + ' rounded-full object-cover border-2 ' + border + '">' : '') +
        '</div>';
    }

    /* ---------- PRESMA ---------- */
    function presmaLabels() { return state.presma.map(p => 'No.' + p.paslon_ke + ' ' + p.nm_ketua); }
    function presmaVotes() { return state.presma.map(p => Number(p.total_vote)); }

    function buildPresmaChart() {
        if (presmaChart) presmaChart.destroy();
        presmaChart = new Chart(document.getElementById('presma-chart'), {
            type: 'bar',
            data: {
                labels: presmaLabels(),
                datasets: [{
                    data: presmaVotes(),
                    backgroundColor: presmaVotes().map((_, i) => PALETTE[i % PALETTE.length]),
                    borderRadius: 12,
                    borderSkipped: false,
                    barThickness: 'flex',
                    maxBarThickness: 64,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: ctx => ' ' + num(ctx.parsed.x) + ' suara' }
                    },
                    datalabels: {
                        anchor: 'end', align: 'end', color: '#fff',
                        font: { weight: 'bold', size: 14 },
                        formatter: v => num(v),
                    }
                },
                scales: {
                    x: { beginAtZero: true, ticks: { color: '#cbd5e1', precision: 0 }, grid: { color: 'rgba(255,255,255,0.08)' } },
                    y: { ticks: { color: '#fff', font: { size: 14, weight: 'bold' } }, grid: { display: false } },
                },
                animation: { duration: 800 },
            }
        });
    }

    function renderPresmaDuel() {
        const total = presmaVotes().reduce((a, b) => a + b, 0);
        const box = document.getElementById('presma-duel');
        let html = state.presma.map((p, i) => {
            const pct = total > 0 ? (p.total_vote / total * 100) : 0;
            const lead = i === 0 && total > 0;
            return '<div class="rounded-3xl p-6 md:p-8 text-center ' + (lead
                ? 'bg-gradient-to-b from-amber-400/30 via-orange-500/15 to-transparent border-2 border-amber-400 shadow-[0_0_50px_rgba(251,191,36,0.35)]'
                : 'bg-white/5 border border-white/10') + '">' +
                (lead
                    ? '<span class="inline-block text-[11px] font-extrabold tracking-widest text-amber-950 bg-amber-400 px-4 py-1 rounded-full">UNGGUL SEMENTARA</span>'
                    : '<span class="inline-block text-[11px] font-extrabold tracking-widest text-blue-200 bg-white/10 px-4 py-1 rounded-full">PASLON ' + p.paslon_ke + '</span>') +
                '<div class="flex justify-center my-5">' + fotoPair(p, 'w-24 h-24 md:w-28 md:h-28', lead ? 'border-amber-400' : 'border-white/30') + '</div>' +
                '<p class="text-xl md:text-2xl font-extrabold text-white leading-snug">' + pasanganName(p) + '</p>' +
                '<p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">Paslon ' + p.paslon_ke + '</p>' +
                '<p class="text-5xl md:text-6xl font-extrabold mt-4 ' + (lead ? 'text-amber-400' : 'text-white') + '">' + num(p.total_vote) + '</p>' +
                '<p class="text-sm font-bold text-gray-300 mt-1">' + pct.toFixed(1) + '% suara presma</p>' +
                '<div class="w-full bg-white/10 rounded-full h-2.5 mt-4 overflow-hidden">' +
                    '<div class="h-2.5 rounded-full transition-all duration-700 ' + (lead ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-blue-500') + '" style="width:' + pct.toFixed(1) + '%"></div>' +
                '</div>' +
            '</div>';
        }).join('');
        box.innerHTML = html;
    }

    /* ---------- HIMA ---------- */
    function buildHimaCharts() {
        himaCharts.length = 0;
        state.hima.forEach((g, gi) => {
            const canvas = document.getElementById('hima-chart-' + gi);
            if (!canvas) return;
            himaCharts[gi] = new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: g.paslons.map(p => 'No.' + p.paslon_ke + ' ' + p.nm_ketua),
                    datasets: [{
                        data: g.paslons.map(p => Number(p.total_vote)),
                        backgroundColor: g.paslons.map((_, i) => PALETTE[i % PALETTE.length]),
                        borderColor: '#f8fafc',
                        borderWidth: 4,
                        hoverOffset: 10,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + num(ctx.parsed) + ' suara' } },
                        datalabels: {
                            color: '#fff',
                            font: { weight: 'bold', size: 13 },
                            formatter: (v, ctx) => {
                                const sum = ctx.dataset.data.reduce((a, b) => a + Number(b), 0);
                                return sum > 0 ? Math.round(v / sum * 100) + '%' : '';
                            }
                        },
                        centerText: { lines: [num(g.total), 'suara'] },
                    }
                },
                plugins: [centerText],
            });
            renderHimaLegend(gi);
        });
    }

    function renderHimaLegend(gi) {
        const g = state.hima[gi];
        if (!g) return;
        const box = document.getElementById('hima-legend-' + gi);
        if (!box) return;
        box.innerHTML = g.paslons.map((p, i) => {
            const pct = g.total > 0 ? (p.total_vote / g.total * 100) : 0;
            return '<div class="flex items-center gap-3 bg-white border rounded-2xl px-4 py-3 shadow-sm ' + (i === 0 && g.total > 0 ? 'border-amber-400 ring-1 ring-amber-300' : 'border-slate-200') + '">' +
                '<span class="w-4 h-4 rounded-full shrink-0" style="background:' + PALETTE[i % PALETTE.length] + '"></span>' +
                fotoPair(p, 'w-14 h-14', 'border-slate-200') +
                '<div class="min-w-0 flex-1"><p class="font-bold text-slate-800 text-sm truncate">' + pasanganName(p) + '</p>' +
                '<p class="text-xs text-slate-500">Paslon ' + p.paslon_ke + ' &bull; ' + pct.toFixed(1) + '%</p></div>' +
                '<p class="font-extrabold text-blue-950 shrink-0">' + num(p.total_vote) + '</p>' +
            '</div>';
        }).join('');
        const totalEl = document.getElementById('hima-total-' + gi);
        if (totalEl) totalEl.textContent = num(g.total) + ' suara';
    }

    /* ---------- CAROUSEL ---------- */
    function slideCount() { return state.hima.length; }

    function go(i) {
        const n = slideCount();
        if (!n) return;
        slide = (i + n) % n;
        document.getElementById('hima-track').style.transform = 'translateX(-' + (slide * 100) + '%)';
        document.querySelectorAll('#hima-dots button').forEach((d, di) => {
            d.className = 'h-2.5 rounded-full transition-all ' + (di === slide ? 'w-8 bg-orange-500' : 'w-2.5 bg-slate-400/60 hover:bg-slate-500');
        });
        if (himaCharts[slide]) himaCharts[slide].resize();
    }

    function buildDots() {
        const dots = document.getElementById('hima-dots');
        dots.innerHTML = '';
        for (let i = 0; i < slideCount(); i++) {
            const b = document.createElement('button');
            b.setAttribute('aria-label', 'Slide ' + (i + 1));
            b.addEventListener('click', () => { go(i); restartSlideTimer(); });
            dots.appendChild(b);
        }
    }

    function restartSlideTimer() {
        if (slideTimer) clearInterval(slideTimer);
        if (slideCount() > 1) slideTimer = setInterval(() => go(slide + 1), 10000);
    }

    document.getElementById('hima-prev').addEventListener('click', () => { go(slide - 1); restartSlideTimer(); });
    document.getElementById('hima-next').addEventListener('click', () => { go(slide + 1); restartSlideTimer(); });
    const carousel = document.getElementById('hima-carousel');
    carousel.addEventListener('mouseenter', () => { if (slideTimer) clearInterval(slideTimer); });
    carousel.addEventListener('mouseleave', restartSlideTimer);

    /* ---------- REALTIME POLL ---------- */
    function renderStats(s) {
        document.getElementById('stat-dpt').textContent = num(s.totalPemilih);
        document.getElementById('stat-presma').textContent = num(s.suaraPresma);
        document.getElementById('stat-partisipasi').textContent = s.partisipasi + '%';
        document.getElementById('stat-belum').textContent = num(s.belumMemilih);
        document.getElementById('stat-updated').textContent = s.diperbarui;
    }

    async function refresh() {
        try {
            const res = await fetch(DATA_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return;
            const s = await res.json();
            const presmaLenChanged = s.presma.length !== state.presma.length;
            const himaLenChanged = s.hima.length !== state.hima.length ||
                s.hima.some((g, i) => !state.hima[i] || g.paslons.length !== state.hima[i].paslons.length);

            state = s;
            renderStats(s);

            if (presmaLenChanged) { buildPresmaChart(); }
            else if (presmaChart) {
                presmaChart.data.labels = presmaLabels();
                presmaChart.data.datasets[0].data = presmaVotes();
                presmaChart.data.datasets[0].backgroundColor = presmaVotes().map((_, i) => PALETTE[i % PALETTE.length]);
                presmaChart.update();
            }
            renderPresmaDuel();

            if (himaLenChanged) { buildHimaCharts(); buildDots(); go(Math.min(slide, slideCount() - 1)); restartSlideTimer(); }
            else {
                s.hima.forEach((g, gi) => {
                    if (!himaCharts[gi]) return;
                    himaCharts[gi].data.labels = g.paslons.map(p => 'No.' + p.paslon_ke + ' ' + p.nm_ketua);
                    himaCharts[gi].data.datasets[0].data = g.paslons.map(p => Number(p.total_vote));
                    himaCharts[gi].options.plugins.centerText.lines = [num(g.total), 'suara'];
                    himaCharts[gi].update();
                    renderHimaLegend(gi);
                });
            }
        } catch (e) { /* abaikan, coba lagi 10 detik berikutnya */ }
    }

    /* ---------- INIT ---------- */
    buildPresmaChart();
    renderPresmaDuel();
    buildHimaCharts();
    buildDots();
    go(0);
    restartSlideTimer();
    pollTimer = setInterval(refresh, 10000);
})();
</script>
@endsection
