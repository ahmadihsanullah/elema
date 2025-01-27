<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\SesiBelajarResource\Pages;
use App\Filament\Guru\Resources\SesiBelajarResource\RelationManagers;
use App\Models\GuruMataPelajaran;
use App\Models\MataPelajaran;
use App\Models\SesiBelajar;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SesiBelajarResource extends Resource
{
    protected static ?string $model = SesiBelajar::class;

    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
   

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('id_guru_mata_pelajaran')
                    ->label("Mata Pelajaran")
                    ->options(GuruMataPelajaran::where('id_guru', Auth::user()->id)
                        ->get()
                        ->map(function ($record) { 
                            return [$record->id => $record->mataPelajaran->nama];
                        }))
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guruMataPelajaran.mataPelajaran.nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Kelola Sesi'),
                Tables\Actions\DeleteAction::make()
                ->label('Hapus Sesi')
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
            'index' => Pages\ListSesiBelajars::route('/'),
            'create' => Pages\CreateSesiBelajar::route('/create'),
            'edit' => Pages\EditSesiBelajar::route('/{record:slug}/edit')
        ];
    }
}
