<?php

namespace App\Filament\Siswa\Pages;

use App\Models\SesiBelajar;
use Filament\Pages\Page;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Session extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.siswa.pages.session';
    protected static bool $shouldRegisterNavigation = false;

    public $materi;
    public $tugas;
    public $fileMateri;
    public $kuis;
    public $sesiBelajar;


    protected static ?string $slug = 'my-courses/session/{slug}'; // Custom URL slug

    public function mount($slug)
    {
        $this->sesiBelajar = SesiBelajar::where('slug', $slug)->first();
        $this->materi = $this->sesiBelajar->materi;
        $this->tugas = $this->sesiBelajar->tugas;
        $this->kuis = $this->sesiBelajar->kuis;
        $this->fileMateri = $this->sesiBelajar->fileMateris;
    }

    public function downloadFile($path): BinaryFileResponse
    {
        // Jika file tersimpan di storage Laravel, gunakan storage_path atau public_path
        $fullPath = storage_path('app/public/' . $path);

        // Pastikan file ada
        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan');
        }

        // Mengembalikan response download
        return response()->download($fullPath);
    }

}
