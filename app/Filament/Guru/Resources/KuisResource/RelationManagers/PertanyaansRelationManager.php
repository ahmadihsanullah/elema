<?php

namespace App\Filament\Guru\Resources\KuisResource\RelationManagers;

use App\Filament\Guru\Resources\PertanyaanResource;
use App\Filament\Imports\PertanyaanImporter;
use App\Imports\PertanyaansImport;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaansRelationManager extends RelationManager
{
    protected static string $relationship = 'pertanyaans';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pertanyaan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('penjelasan')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('bobot')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pertanyaan')
            ->columns([
                Tables\Columns\TextColumn::make('pertanyaan'),
                Tables\Columns\TextColumn::make('bobot')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // Tambahkan custom action untuk import
                Tables\Actions\Action::make('importSoal')
                    ->label('Import Soal')
                    ->action(function (array $data) {
                        if (isset($data['file'])) {
                            try {
                                $filePath = Storage::disk('public')->path($data['file']);

                                // Dapatkan id kuis dari URL atau dari record yang sedang di-edit
                                $kuisId = $this->getOwnerRecord()->id; // Mengambil dari Filament record
                                // Import file menggunakan path dan id kuis dari record
                                Excel::import(new PertanyaansImport($kuisId), $filePath);
                                Storage::disk('public')->delete($data['file']);
                                Notification::make()
                                    ->title('Berhasil upload')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Gagal upload' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        } else {
                            Notification::make()
                                ->title('Gagal upload file tidak terbaca')
                                ->danger()
                                ->send();
                        }
                    })
                    ->form([
                        FileUpload::make('file')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('importsoal')
                            ->label('Import Soal')
                            ->acceptedFileTypes(['text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->required(),
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->url(fn(Model $record): string => PertanyaanResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
