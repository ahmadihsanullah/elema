<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\KuisResource\Pages;
use App\Filament\Guru\Resources\KuisResource\RelationManagers;
use App\Filament\Guru\Resources\KuisResource\RelationManagers\PertanyaansRelationManager;
use App\Models\Kuis;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KuisResource extends Resource
{
    protected static ?string $model = Kuis::class;

    protected static ?string $navigationIcon = 'heroicon-s-fire';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kuis')->schema([
                    Forms\Components\TextInput::make('judul')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('deskripsi')
                        ->columnSpanFull(),
                    Forms\Components\DateTimePicker::make('waktu_mulai'),
                    Forms\Components\DateTimePicker::make('waktu_selesai'),
                    Forms\Components\TextInput::make('nilai_minimal')
                        ->required()
                        ->numeric()
                        ->minValue(0) // Kamu bisa atur nilai minimal
                        ->maxValue(100) // Jika ingin ada batasan maksimal (misal 100)
                        ->label('Nilai Minimal'),
                        Forms\Components\TextInput::make('durasi')
                            ->numeric()
                            ->label('Durasi Pengerjaan(menit)'),
                    Forms\Components\Toggle::make('aktif')
                        ->required(),
                    Forms\Components\Toggle::make('acak_soal')
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('durasi')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_mulai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_selesai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('acak_soal')
                    ->boolean(),
                Tables\Columns\IconColumn::make('nilai_minimal')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            PertanyaansRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKuis::route('/'),
            'create' => Pages\CreateKuis::route('/create'),
            'edit' => Pages\EditKuis::route('/{record}/edit'),
        ];
    }
}
