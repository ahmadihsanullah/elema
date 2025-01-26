<?php

namespace App\Filament\Guru\Resources\SesiBelajarResource\Pages;

use App\Filament\Guru\Resources\SesiBelajarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSesiBelajars extends ListRecords
{
    protected static string $resource = SesiBelajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
