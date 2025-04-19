<?php

namespace App\Filament\Guru\Pages;

use App\Models\HasilKuis;
use App\Models\Kuis;
use Filament\Actions\EditAction;
use Filament\Pages\Page;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ViewQuizResult extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.guru.pages.view-quiz-result';

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';


    protected static ?string $slug = 'view-quiz-result/{id}'; // Custom URL slug
    public $kuis;
    public $hasilKuis;
    public $slugSesiBelajar;

    public function mount($id)
    {
        $this->kuis = Kuis::where('slug', $id)->first();

        if ($this->kuis) {
            // Retrieve quiz results for all students who have taken the quiz
            $this->hasilKuis = HasilKuis::with('siswa')
                ->where('id_kuis', $this->kuis->id)
                ->get();
        }
        $this->slugSesiBelajar = $this->kuis->sesiBelajars;
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => HasilKuis::where('id_kuis', $this->kuis->id))
            ->columns([
                TextColumn::make('siswa.name')
                    ->label('Nama Siswa'),
                TextColumn::make('siswa.kelas.nama')
                    ->label('Kelas'),
                TextColumn::make('skor')
                    ->label('Nilai')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'in_progress' => 'warning',
                        'expired' => 'danger',
                    })
                
            ])
            ->actions([
                DeleteAction::make()
            ])
            ->filters([
                // Filter untuk mencari siswa berdasarkan nama
                \Filament\Tables\Filters\Filter::make('siswa_name')
                    ->label('Cari Nama Siswa')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('siswa_name')
                            ->label('Nama Siswa')
                            ->placeholder('Cari nama siswa...')
                    ])
                    ->query(fn(Builder $query, array $data) => $query->when(
                        $data['siswa_name'],
                        fn(Builder $query, $name) =>
                        $query->whereHas('siswa', fn(Builder $query) => $query->where('name', 'like', "%{$name}%"))
                    )),
            ]);
        ;
    }

    public function backToSession()
    {
        return redirect()->route('filament.guru.resources.sesi-belajars.edit', 
            $this->slugSesiBelajar,
        );

    }

    public function getResults()
    {
        return $this->hasilKuis;
    }
}
