<?php

namespace App\Filament\Guru\Resources\SesiBelajarResource\RelationManagers;

use App\Models\Materi;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MateriRelationManager extends RelationManager
{
    protected static string $relationship = 'materi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('deskripsi')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('gambarmateri')
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                Tables\Columns\TextColumn::make('judul'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->disabled(function () {
                        // Hide Create button if 'materi' already exists for this relationship
                        return $this->ownerRecord->materi()->exists();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                        ->action(function (Materi $record) {
                            // Coba hapus file yang terkait dari penyimpanan
                            try {
                                if (!empty($record->deskripsi)) {
                                    $dom = new \DOMDocument();
                                    @$dom->loadHTML($record->deskripsi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                                    $figures = $dom->getElementsByTagName('figure');
        
                                    foreach ($figures as $figure) {
                                        $attachment = $figure->getAttribute('data-trix-attachment');
                                        if ($attachment) {
                                            $attachmentData = json_decode(html_entity_decode($attachment), true);
                                            if (isset($attachmentData['url'])) {
                                                $path = parse_url($attachmentData['url'], PHP_URL_PATH);
                                                $relativePath = ltrim($path, '/');
                                    
                                                // Hapus 'storage/' dari jalur relatif, karena Storage::disk('public') sudah menangani ini
                                                if (str_starts_with($relativePath, 'storage/')) {
                                                    $relativePath = substr($relativePath, strlen('storage/'));
                                                }
                                    
                                    
                                                // Tampilkan jalur relatif gambar untuk debugging
                                                \Log::info('Attempting to delete image: ' . $relativePath);
                                    
                                                // Hapus file jika ditemukan
                                                if (Storage::disk('public')->exists($relativePath)) {
                                                    Storage::disk('public')->delete($relativePath);
                                                    \Log::info('Image deleted: ' . $relativePath);
                                                } else {
                                                    \Log::warning('Image not found: ' . $relativePath);
                                                }
                                            }
                                        }
                                    }
                                    
                                }
                            } catch (\Exception $e) {
                                \Log::error('Error while deleting image: ' . $e->getMessage());
                                // Mungkin penghapusan file gagal, tapi kita tetap ingin menghapus record
                            }
        
                            // Lanjutkan dengan penghapusan record, terlepas dari keberhasilan penghapusan file
                            $record->delete();
        
                            // Log untuk memastikan record terhapus
                            \Log::info('Materi record deleted: ' . $record->id);
                        })
                        ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
