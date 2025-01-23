<?php

namespace App\Filament\Guru\Pages;

use Filament\Pages\Page;
use App\Models\MataPelajaran;

class KelolaMataPelajaran extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.guru.pages.kelola-mata-pelajaran';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Kelola Mata Pelajaran';
    protected static ?string $slug = 'mata-pelajaran/{slugGuruMapel}'; // Custom URL slug
}