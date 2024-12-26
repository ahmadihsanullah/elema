<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 3;
    
    protected static ?string $navigationLabel = 'Siswa';

    public static function getModelLabel(): string
    {
        return 'Siswa';
    }
    
    public static function getPluralModelLabel(): string
    {
        return 'Siswa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options([
                        'l' => 'laki-laki',
                        'p' => 'perempuan',
                    ])
                    ->required(),
                Forms\Components\Select::make('id_kelas')
                    ->required()
                    ->relationship('kelas', 'id')
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return $record->kode;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('index')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('jenis_kelamin')
                    ->formatStateUsing(fn($state) => $state === 'l' ? 'Laki-Laki' : 'Perempuan')
                    ->colors([
                        'primary' => fn($state) => $state === 'l',
                        'success' => fn($state) => $state === 'p',
                    ]),
                Tables\Columns\TextColumn::make('kelas.nama')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('kelas.jurusan.nama')
                    ->sortable()
                    ->colors([
                        'primary' => fn($state) => $state === 'Akuntansi',
                        'success' => fn($state) => $state === 'Teknik Komputer Jaringan',
                        'warning' => fn($state) => $state === 'Teknik Audio Visual',
                        'danger' => fn($state) => $state === 'Administrasi Perkantoran',
                    ]),
                Tables\Columns\TextColumn::make('kelas.angkatan.tahun')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jurusan')
                    ->relationship('kelas.jurusan', 'nama')
                    ->label('Filter Jurusan')
                    ->placeholder('Pilih Jurusan'),
                Tables\Filters\SelectFilter::make('angkatan ')
                    ->relationship('kelas.angkatan', 'tahun')
                    ->label('Filter Angkatan')
                    ->placeholder('Pilih Angkatan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
