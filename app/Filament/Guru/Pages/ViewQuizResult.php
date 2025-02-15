<?php

namespace App\Filament\Guru\Pages;

use App\Models\HasilKuis;
use App\Models\Kuis;
use Filament\Pages\Page;

class ViewQuizResult extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.guru.pages.view-quiz-result';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'view-quiz-result/{id}'; // Custom URL slug
    public $kuis;
    public $hasilKuis;

    public function mount($id)
    {
        $this->kuis = Kuis::where('slug',$id)->first();

        if ($this->kuis) {
            // Retrieve quiz results for all students who have taken the quiz
            $this->hasilKuis = HasilKuis::with('siswa')
                ->where('id_kuis', $this->kuis->id)
                ->get();
        }
    }

    public function getResults()
    {
        return $this->hasilKuis;
    }
}
