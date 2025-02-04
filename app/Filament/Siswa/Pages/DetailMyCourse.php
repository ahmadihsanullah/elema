<?php

namespace App\Filament\Siswa\Pages;

use App\Models\GuruMataPelajaran;
use App\Models\SesiBelajar;
use Filament\Pages\Page;

class DetailMyCourse extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.siswa.pages.detail-my-course';
    protected static ?string $slug = 'my-courses/{slugMapel}'; // Custom URL slug

    public $guruMapel = '';
    public $mataPelajaran = '';
    public $sesiBelajars = [];
    public function mount($slugMapel)
    {
        // Ambil mata pelajaran berdasarkan slug
        $this->guruMapel = GuruMataPelajaran::where('slug', $slugMapel)->first();
        // $this->sesiBelajar = SesiBelajar::where("id_guru_mata_pelajaran", $this->guruMapel->id)->get();
        $this->sesiBelajars = $this->guruMapel->sesiBelajar;
    }

    public function sesiBelajar($slug)
    {
        return redirect()->route('filament.siswa.pages.my-courses.session.{slug}', ['slug' => $slug]);
    }


}
