<?php

namespace App\Filament\Guru\Pages;

use App\Models\Guru;
use App\Models\GuruMataPelajaran;
use Filament\Pages\Page;
use App\Models\MataPelajaran;
use App\Models\SesiBelajar;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class KelolaMataPelajaran extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithFormActions;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.guru.pages.kelola-mata-pelajaran';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Kelola Mata Pelajaran';
    protected static ?string $slug = 'mata-pelajaran/{slugGuruMapel}'; // Custom URL slug
    public $guruMapel;
    public $mataPelajaran;
    public $judul;

    public function mount($slugGuruMapel)
    {
        // Ambil mata pelajaran berdasarkan slug
        $this->guruMapel = GuruMataPelajaran::where('slug', $slugGuruMapel)->first();

        if (!$this->guruMapel) {
            abort(404);
        }
        $this->mataPelajaran = $this->guruMapel->mataPelajaran->nama;
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('judul')
                ->label('Sesi Belajar')
                ->required()

        ];
    }
    public function save()
    {
        $this->validate([
           'judul' => 'required'
        ]); 

        $guruMapel = GuruMataPelajaran::where('slug', $this->guruMapel->slug)->first();

        if (!empty($this->judul)) {
            SesiBelajar::create([
                'judul' => $this->judul,
                'id_guru_mata_pelajaran' => $guruMapel->id
            ]);
        }

        Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Sesi Belajar berhasil ditambah.')
            ->send();

        // Refresh the table
        $this->dispatch('refresh-table');
    }

    public function table(Table $table): Table
    {
        return $table
        ->query(fn() => SesiBelajar::where('id_guru_mata_pelajaran', $this->guruMapel->id))
            ->columns([
                TextColumn::make('judul')
                    ->label('Sesi Belajar')
                    ->getStateUsing(function (SesiBelajar $record) {
                        return $record->judul;
                    })
                    ->color('primary')
                    ->searchable()
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
               BulkActionGroup::make([
                   DeleteBulkAction::make(),
                ]),
            ]);
    }
}
