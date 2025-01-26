<?php

namespace App\Filament\Guru\Resources\SesiBelajarResource\Pages;

use App\Filament\Guru\Resources\SesiBelajarResource;
use App\Models\SesiBelajar;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSesiBelajar extends EditRecord
{
    protected static string $resource = SesiBelajarResource::class;

    public function mount(int|string $record): void {
        $this->record = SesiBelajar::findOrFail($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
