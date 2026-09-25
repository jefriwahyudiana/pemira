<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaslonResource\Pages;
use App\Models\Paslon;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Facades\Storage;

class PaslonResource extends Resource
{
    protected static ?string $model = Paslon::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Kelola Pemilu';

    protected static ?string $navigationLabel = 'Paslon';

    protected static ?string $modelLabel = 'Paslon';

    protected static ?string $pluralModelLabel = 'Paslon';

    protected static ?int $navigationSort = 1;

    public static function form(Forms\Form $form): Forms\Form
    {
        $prodiOptions = [
            'D3 Teknik Informatika' => 'D3 Teknik Informatika',
            'D4 Teknik Informatika' => 'D4 Teknik Informatika',
            'D3 Administrasi Logistik' => 'D3 Administrasi Logistik',
            'D4 Logistik Bisnis' => 'D4 Logistik Bisnis',
            'S1 Manajemen Logistik' => 'S1 Manajemen Logistik',
            'S1 Bisnis Digital' => 'S1 Bisnis Digital',
            'S1 Sains Data' => 'S1 Sains Data',
            'S1 Manajemen Rekayasa' => 'S1 Manajemen Rekayasa',
            'D4 Logistik Niaga-EL' => 'D4 Logistik Niaga-EL',
            'S1 Manajemen Transportasi' => 'S1 Manajemen Transportasi',
            'D4 Manajemen Perusahaan' => 'D4 Manajemen Perusahaan',
            'D3 Manajemen Pemasaran' => 'D3 Manajemen Pemasaran',
            'D3 Akuntansi' => 'D3 Akuntansi',
            'D4 Akuntansi Keuangan' => 'D4 Akuntansi Keuangan',
            'D3 Manajemen informatika' => 'D3 Manajemen informatika',
        ];

        return $form
            ->schema([
                Forms\Components\Section::make('Nomor & Jenis Pemilihan')
                    ->icon('heroicon-o-numbered-list')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('paslon_ke')
                            ->label('Nomor Paslon')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Forms\Components\Select::make('jenis_pemilihan')
                            ->label('Jenis Pemilihan')
                            ->options([
                                'himatif' => 'Himatif',
                                'himagis' => 'Himagis',
                                'himalogbis' => 'Himalogbis',
                                'himaporta' => 'Himaporta',
                                'himanbis' => 'Himanbis',
                                'hma' => 'HMA',
                                'himabig' => 'Himabig',
                                'hicomlog' => 'Hicomlog',
                                'himasta' => 'Himasta',
                                'himamera' => 'Himamera',
                                'hmmi' => 'Hmmi',
                                'presma' => 'Presma',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('total_vote')
                            ->label('Total Suara')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Otomatis dari hasil voting, tidak dapat diubah manual.'),
                    ]),

                Forms\Components\Section::make('Data Ketua')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nm_ketua')
                            ->label('Nama Ketua')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('npm_ketua')
                            ->label('NPM Ketua')
                            ->required()
                            ->numeric(),
                        Forms\Components\Select::make('pd_ketua')
                            ->label('Prodi Ketua')
                            ->options($prodiOptions)
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('ang_ketua')
                            ->label('Angkatan Ketua')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jbt_ketua')
                            ->label('Jabatan Ketua')
                            ->options([
                                'Presiden Mahasiswa' => 'Presiden Mahasiswa',
                                'Ketua Himpunan' => 'Ketua Himpunan',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\FileUpload::make('ft_ketua')
                            ->label('Foto Ketua')
                            ->disk('public')
                            ->directory('fotoPaslon')
                            ->visibility('public')
                            ->image()
                            ->maxSize(1024 * 4)
                            ->required()
                            // URL relatif agar preview tidak diblokir CORS saat admin
                            // diakses via host berbeda (localhost vs 127.0.0.1)
                            ->getUploadedFileUsing(function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
                                $disk = Storage::disk('public');

                                if (! $disk->exists($file)) {
                                    return null;
                                }

                                return [
                                    'name' => $storedFileNames ?? basename($file),
                                    'size' => $disk->size($file),
                                    'type' => $disk->mimeType($file),
                                    'url' => '/storage/' . ltrim($file, '/'),
                                ];
                            }),
                    ]),

                Forms\Components\Section::make('Data Wakil')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nm_wakil')
                            ->label('Nama Wakil')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('npm_wakil')
                            ->label('NPM Wakil')
                            ->required()
                            ->numeric(),
                        Forms\Components\Select::make('pd_wakil')
                            ->label('Prodi Wakil')
                            ->options($prodiOptions)
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('ang_wakil')
                            ->label('Angkatan Wakil')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jbt_wakil')
                            ->label('Jabatan Wakil')
                            ->options([
                                'Wakil Presiden Mahasiswa' => 'Wakil Presiden Mahasiswa',
                                'Wakil Ketua Himpunan' => 'Wakil Ketua Himpunan',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\FileUpload::make('ft_wakil')
                            ->label('Foto Wakil')
                            ->disk('public')
                            ->directory('fotoPaslon')
                            ->visibility('public')
                            ->image()
                            ->maxSize(1024 * 4)
                            ->required()
                            // URL relatif agar preview tidak diblokir CORS saat admin
                            // diakses via host berbeda (localhost vs 127.0.0.1)
                            ->getUploadedFileUsing(function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
                                $disk = Storage::disk('public');

                                if (! $disk->exists($file)) {
                                    return null;
                                }

                                return [
                                    'name' => $storedFileNames ?? basename($file),
                                    'size' => $disk->size($file),
                                    'type' => $disk->mimeType($file),
                                    'url' => '/storage/' . ltrim($file, '/'),
                                ];
                            }),
                    ]),

                Forms\Components\Section::make('Visi & Misi')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\Textarea::make('visi')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('misi')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paslon_ke')
                    ->label('No.')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('ft_ketua')
                    ->disk('public')
                    ->label('Ketua')
                    ->circular(),
                Tables\Columns\TextColumn::make('nm_ketua')
                    ->label('Pasangan')
                    ->description(fn ($record): string => $record->nm_wakil ?? 'Calon tunggal')
                    ->searchable(['nm_ketua', 'nm_wakil']),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->label('Pemilihan')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_vote')
                    ->label('Total Suara')
                    ->badge()
                    ->color('success')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pd_ketua')
                    ->label('Prodi Ketua')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('pd_wakil')
                    ->label('Prodi Wakil')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_pemilihan')
                    ->label('Jenis Pemilihan')
                    ->options([
                        'himatif' => 'Himatif',
                        'himagis' => 'Himagis',
                        'himalogbis' => 'Himalogbis',
                        'himaporta' => 'Himaporta',
                        'himanbis' => 'Himanbis',
                        'hma' => 'HMA',
                        'himabig' => 'Himabig',
                        'hicomlog' => 'Hicomlog',
                        'himasta' => 'Himasta',
                        'himamera' => 'Himamera',
                        'hmmi' => 'Hmmi',
                        'presma' => 'Presma',
                    ]),
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
            ->emptyStateHeading('Belum ada paslon')
            ->emptyStateDescription('Tambahkan pasangan calon untuk memulai pemilihan.');
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
            'index' => Pages\ListPaslons::route('/'),
            'create' => Pages\CreatePaslon::route('/create'),
            'edit' => Pages\EditPaslon::route('/{record}/edit'),
        ];
    }
}
