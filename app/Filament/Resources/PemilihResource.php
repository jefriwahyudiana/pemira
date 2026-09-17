<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemilihResource\Pages;
use App\Models\Pemilih;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class PemilihResource extends Resource
{
    protected static ?string $model = Pemilih::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Kelola Pemilu';

    protected static ?string $navigationLabel = 'Pemilih';

    protected static ?string $modelLabel = 'Pemilih';

    protected static ?string $pluralModelLabel = 'Pemilih';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pemilih')
                    ->icon('heroicon-o-identification')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('npm')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->helperText('Kosongkan saat edit jika tidak ingin mengganti password.'),
                        Forms\Components\TextInput::make('prodi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jenis_pemilihan')
                            ->label('Jenis Pemilihan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('sudah_login')
                            ->label('Sudah Login')
                            ->inline(false),
                    ]),

                Forms\Components\Section::make('Status Voting')
                    ->icon('heroicon-o-chart-bar')
                    ->description('Otomatis dari hasil voting, tidak dapat diubah manual.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('total_vote')
                            ->label('Total Vote')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('pml_presma')
                            ->label('Vote Presma')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('pml_hima')
                            ->label('Vote Hima')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npm')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('prodi')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->label('Pemilihan')
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('sudah_login')
                    ->label('Login')
                    ->boolean(),
                Tables\Columns\TextColumn::make('total_vote')
                    ->label('Total')
                    ->badge()
                    ->color('success')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pml_presma')
                    ->label('Presma')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pml_hima')
                    ->label('Hima')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_pemilihan')
                    ->label('Jenis Pemilihan'),
                Tables\Filters\TernaryFilter::make('sudah_login')
                    ->label('Sudah Login'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada pemilih')
            ->emptyStateDescription('Tambahkan data pemilih untuk memulai pemilihan.');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemilihs::route('/'),
            'create' => Pages\CreatePemilih::route('/create'),
            'edit' => Pages\EditPemilih::route('/{record}/edit'),
        ];
    }
}
