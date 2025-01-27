<?php

namespace App\Filament\Guru\Resources\SesiBelajarResource\Pages;

use App\Filament\Guru\Resources\SesiBelajarResource;
use App\Models\SesiBelajar;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSesiBelajar extends EditRecord
{
    protected static string $resource = SesiBelajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getHeading(): string
    {
        return 'Kelola Sesi Belajar';
    }
}
