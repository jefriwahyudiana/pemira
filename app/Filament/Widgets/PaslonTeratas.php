<?php

namespace App\Filament\Widgets;

use App\Models\Paslon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PaslonTeratas extends BaseWidget
{
    protected static ?string $heading = 'Paslon Perolehan Tertinggi';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        // Ambil 1 paslon dengan suara tertinggi untuk tiap jenis pemilihan.
        $topIds = Paslon::query()
            ->distinct()
            ->pluck('jenis_pemilihan')
            ->map(fn ($jenis) => Paslon::query()
                ->where('jenis_pemilihan', $jenis)
                ->orderByDesc('total_vote')
                ->orderBy('paslon_ke')
                ->value('id'))
            ->filter()
            ->values()
            ->toArray();

        return $table
            ->query(
                Paslon::query()
                    ->whereIn('id', $topIds ?: [0])
                    ->orderByRaw("CASE WHEN jenis_pemilihan = 'presma' THEN 0 ELSE 1 END")
                    ->orderBy('jenis_pemilihan')
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('paslon_ke')
                    ->label('No.')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('nm_ketua')
                    ->label('Pasangan')
                    ->description(fn ($record): string => $record->nm_wakil ?? ''),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->label('Pemilihan')
                    ->badge(),
                Tables\Columns\TextColumn::make('total_vote')
                    ->label('Suara')
                    ->badge()
                    ->color('success')
                    ->numeric()
                    ->sortable(),
            ])
            ->emptyStateHeading('Belum ada suara masuk')
            ->emptyStateDescription('Peringkat 1 tiap pemilihan akan muncul di sini — Presma di urutan pertama.');
    }
}
