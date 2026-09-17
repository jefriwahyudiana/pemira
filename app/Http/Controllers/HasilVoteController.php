<?php

namespace App\Http\Controllers;

use App\Models\Paslon;
use App\Models\Pemilih;

class HasilVoteController extends Controller
{
    public function index()
    {
        return view('hasil_vote', $this->payload());
    }

    public function data()
    {
        return response()->json($this->payload());
    }

    private function payload(): array
    {
        $totalPemilih = Pemilih::count();
        $sudahMemilih = Pemilih::where('total_vote', '>', 0)->count();

        $presma = Paslon::where('jenis_pemilihan', 'presma')
            ->orderByDesc('total_vote')
            ->orderBy('paslon_ke')
            ->get();
        $suaraPresma = (int) $presma->sum('total_vote');

        $himaGroups = Paslon::where('jenis_pemilihan', '!=', 'presma')
            ->orderBy('jenis_pemilihan')
            ->orderByDesc('total_vote')
            ->orderBy('paslon_ke')
            ->get()
            ->groupBy('jenis_pemilihan');

        $hima = [];
        foreach ($himaGroups as $jenis => $paslons) {
            $hima[] = [
                'jenis' => $jenis,
                'total' => (int) $paslons->sum('total_vote'),
                'paslons' => $paslons->map(fn ($p) => $this->mapPaslon($p))->values()->toArray(),
            ];
        }

        return [
            'totalPemilih' => $totalPemilih,
            'sudahMemilih' => $sudahMemilih,
            'belumMemilih' => max(0, $totalPemilih - $sudahMemilih),
            'partisipasi' => $totalPemilih > 0 ? round($sudahMemilih / $totalPemilih * 100, 1) : 0,
            'suaraPresma' => $suaraPresma,
            'suaraHima' => (int) Paslon::where('jenis_pemilihan', '!=', 'presma')->sum('total_vote'),
            'presma' => $presma->map(fn ($p) => $this->mapPaslon($p))->values()->toArray(),
            'hima' => $hima,
            'diperbarui' => now()->format('H:i:s'),
        ];
    }

    private function mapPaslon(Paslon $paslon): array
    {
        return [
            'id' => $paslon->id,
            'paslon_ke' => $paslon->paslon_ke,
            'nm_ketua' => $paslon->nm_ketua,
            'nm_wakil' => $paslon->nm_wakil,
            'jenis_pemilihan' => $paslon->jenis_pemilihan,
            'total_vote' => (int) $paslon->total_vote,
            'ft_ketua' => $this->fotoUrl($paslon->ft_ketua),
            'ft_wakil' => $this->fotoUrl($paslon->ft_wakil),
        ];
    }

    private function fotoUrl(?string $path): string
    {
        if (! $path) {
            return asset('images/pemira.png');
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
