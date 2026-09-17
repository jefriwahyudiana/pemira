<?php

namespace App\Filament\Widgets;

use App\Models\Paslon;
use App\Models\Pemilih;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PemiraStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalPemilih = Pemilih::count();
        $totalPaslon = Paslon::count();
        $sudahMemilih = Pemilih::where('total_vote', '>', 0)->count();
        $totalSuara = (int) Paslon::sum('total_vote');

        $partisipasi = $totalPemilih > 0
            ? round(($sudahMemilih / $totalPemilih) * 100, 1)
            : 0;

        return [
            Stat::make('Total Pemilih', number_format($totalPemilih))
                ->description('Terdaftar dalam DPT')
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-user-group')
                ->color('primary'),
            Stat::make('Total Paslon', number_format($totalPaslon))
                ->description('Presma + Hima')
                ->descriptionIcon('heroicon-m-users')
                ->icon('heroicon-o-users')
                ->color('info'),
            Stat::make('Sudah Memilih', number_format($sudahMemilih))
                ->description($totalSuara . ' suara sah masuk')
                ->descriptionIcon('heroicon-m-check-badge')
                ->icon('heroicon-o-check-badge')
                ->color('success'),
            Stat::make('Partisipasi', $partisipasi . '%')
                ->description('Dari total pemilih')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->icon('heroicon-o-chart-bar')
                ->color('warning'),
        ];
    }
}
