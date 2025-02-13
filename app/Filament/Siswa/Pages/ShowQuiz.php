<?php

namespace App\Filament\Siswa\Pages;

use App\Models\HasilKuis;
use App\Models\JawabanSiswa;
use App\Models\Kuis;
use App\Models\Jawaban;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Wizard;

class ShowQuiz extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.siswa.pages.show-quiz';
    protected static bool $shouldRegisterNavigation = false;

    public $slugQuiz;
    public $kuis;
    public $soals;
    public $durasi;
    public $jumlahSoal;
    public $jawaban = [];

    public function mount()
    {
        $this->slugQuiz = session('slugQuiz');
        $this->kuis = Kuis::with('pertanyaans.jawabans')->where('slug', $this->slugQuiz)->first();
        $this->soals = $this->kuis ? $this->kuis->pertanyaans : [];
        $this->durasi = $this->kuis->durasi;
        $this->jumlahSoal = $this->soals->count();
        $this->jawaban = array_fill(0, $this->jumlahSoal, null);
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                $this->soals->map(function ($soal, $index) {
                    return Forms\Components\Wizard\Step::make('Soal ' . ($index + 1))
                        ->schema([
                            Forms\Components\Fieldset::make('Pertanyaan')
                                ->schema([
                                    Forms\Components\Placeholder::make('pertanyaan')
                                        ->label('')
                                        ->content($soal->pertanyaan),
                                    Forms\Components\Radio::make('jawaban.' . $index)
                                        ->label('Pilih jawaban:')
                                        ->options($soal->jawabans->pluck('jawaban', 'id')->toArray())
                                        ->required(),
                                ]),
                        ]);
                })->toArray()
            )->submitAction(new HtmlString(Blade::render(<<<BLADE
            <x-filament::button
                wire:click="simpanJawaban"
                type="submit"
                size="sm"
                label="Selesai"
            >
               Selesai
            </x-filament::button>
        BLADE)))
        ];
    }

    public function simpanJawaban()
    {
        DB::transaction(function () {
            $hasilKuis = HasilKuis::create([
                'id_kuis' => $this->kuis->id,
                'id_siswa' => auth()->id(),
                'waktu_mulai' => now(),
                'waktu_selesai' => now(),
                'status' => 'selesai',
            ]);

            $skor = 0;
            foreach ($this->soals as $index => $soal) {
                JawabanSiswa::create([
                    'id_hasil_kuis' => $hasilKuis->id,
                    'id_pertanyaan' => $soal->id,
                    'id_jawaban' => $this->jawaban[$index],
                ]);

                $jawabanBenar = Jawaban::where('id', $this->jawaban[$index])
                    ->where('jawaban_benar', true)
                    ->exists();

                if ($jawabanBenar) {
                    $skor += $soal->bobot; // Tambahkan bobot pertanyaan ke skor
                }
            }

            $hasilKuis->update(['skor' => $skor]);

            session()->flash('status', 'Kuis selesai! Nilai Anda: ' . $skor);
            return redirect()->route('filament.siswa.pages.quiz-result.{slugQuiz}', ['slugQuiz' => $this->slugQuiz]);
        });
    }
}
