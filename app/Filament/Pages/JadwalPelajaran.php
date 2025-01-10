<?php

namespace App\Filament\Pages;

use App\Models\Kelas;
use App\Models\GuruMataPelajaran;
use App\Models\TahunPelajaran;
use App\Models\JadwalPelajaran as ModelJadwalPelajaran;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Illuminate\Support\Facades\DB;

class JadwalPelajaran extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Jadwal Pelajaran';
    protected static ?string $title = 'Manajemen Jadwal Pelajaran';
    protected static ?string $navigationGroup = 'Master Data';
    protected static string $view = 'filament.pages.jadwal-pelajaran';
    public $kelas = null;
    public $tahunPelajaran = null;
    public $hari = null;
    public $jadwalPelajaran = [];
    public $jadwalPelajaranToRemove = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => ModelJadwalPelajaran::whereHas('tahunPelajaran', function ($query) {
                $query->where('aktif', true);
            })->with([
                'kelas', 
                'tahunPelajaran', 
                'guruMataPelajaran.mataPelajaran', 
                'guruMataPelajaran.guru'
            ]))
            ->columns([
                TextColumn::make('kelas.nama')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hari')
                    ->label('Hari')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->getStateUsing(function (ModelJadwalPelajaran $record) {
                        return $record->guruMataPelajaran->mataPelajaran->kode . 
                               ' (' . $record->guruMataPelajaran->guru->name . ')';
                    })
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('tahun_pelajaran')
                    ->label('Tahun Pelajaran')
                    ->relationship('tahunPelajaran', 'nama')
                    ->options(TahunPelajaran::where('aktif', true)->pluck('nama', 'id')),
                SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama'),
                SelectFilter::make('hari')
                    ->label('Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                    ])
                    ]);
    }
    public function getFormSchema(): array
    {
        return [
            Select::make('tahunPelajaran')
                ->label('Tahun Pelajaran')
                ->options(TahunPelajaran::all()->pluck('nama', 'id'))
                ->required()
                ->live()
                ->afterStateUpdated(function (callable $set) {
                    $set('kelas', null);
                    $set('hari', null);
                    $set('jadwalPelajaran', []);
                    $set('jadwalPelajaranToRemove', []);
                }),

            Select::make('kelas')
                ->label('Pilih Kelas')
                ->options(function ($get) {
                    $tahunPelajaranId = $get('tahunPelajaran');
                    return $tahunPelajaranId 
                        ? Kelas::all()->pluck('nama', 'id')  
                        : [];
                })
                ->required()
                ->live()
                ->afterStateUpdated(function (callable $set) {
                    $set('hari', null);
                    $set('jadwalPelajaran', []);
                    $set('jadwalPelajaranToRemove', []);
                }),

            Select::make('hari')
                ->label('Pilih Hari')
                ->options([
                    'Senin' => 'Senin',
                    'Selasa' => 'Selasa',
                    'Rabu' => 'Rabu',
                    'Kamis' => 'Kamis',
                    'Jumat' => 'Jumat',
                ])
                ->required()
                ->live()
                ->afterStateUpdated(function (callable $set) {
                    $set('jadwalPelajaran', []);
                    $set('jadwalPelajaranToRemove', []);
                }),

            Select::make('jadwalPelajaran')
                ->label('Tambah Mata Pelajaran')
                ->multiple()
                ->options(function ($get) {
                    $kelasId = $get('kelas');
                    $tahunPelajaranId = $get('tahunPelajaran');
                    $hari = $get('hari');
                    
                    if (!$kelasId || !$tahunPelajaranId || !$hari) return [];

                    // Ambil guru mata pelajaran yang belum terjadwal di hari tersebut
                    return GuruMataPelajaran::whereNotIn('id', function ($query) use ($kelasId, $tahunPelajaranId, $hari) {
                        $query->select('id_guru_mata_pelajaran')
                              ->from('jadwal_pelajarans')
                              ->where('id_kelas', $kelasId)
                              ->where('id_tahun_pelajaran', $tahunPelajaranId)
                              ->where('hari', $hari);
                    })
                    ->with(['mataPelajaran', 'guru'])
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [
                            $item->id => $item->mataPelajaran->kode . 
                                         ' - ' . $item->guru->name
                        ];
                    });
                })
                ->required(),
                

            Select::make('jadwalPelajaranToRemove')
                ->label('Hapus Mata Pelajaran')
                ->multiple()
                ->options(function ($get) {
                    $kelasId = $get('kelas');
                    $tahunPelajaranId = $get('tahunPelajaran');
                    $hari = $get('hari');
                    
                    if (!$kelasId || !$tahunPelajaranId || !$hari) return [];

                    return ModelJadwalPelajaran::where('id_kelas', $kelasId)
                        ->where('id_tahun_pelajaran', $tahunPelajaranId)
                        ->where('hari', $hari)
                        ->with(['guruMataPelajaran.mataPelajaran', 'guruMataPelajaran.guru'])
                        ->get()
                        ->mapWithKeys(function ($item) {
                            return [
                                $item->id => $item->guruMataPelajaran->mataPelajaran->kode . 
                                             ' - ' . $item->guruMataPelajaran->guru->name
                            ];
                        });
                }),
        ];
    }

    public function save()
    {
        $this->validate([
            'kelas' => 'required|exists:kelas,id',
            'tahunPelajaran' => 'required|exists:tahun_pelajarans,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
        ]);
    
        DB::beginTransaction();
        try {
            // Tambah jadwal baru
            if (!empty($this->jadwalPelajaran)) {
                foreach ($this->jadwalPelajaran as $guruMataPelajaranId) {
                    ModelJadwalPelajaran::create([
                        'id_kelas' => $this->kelas,
                        'id_tahun_pelajaran' => $this->tahunPelajaran,
                        'id_guru_mata_pelajaran' => $guruMataPelajaranId,
                        'hari' => $this->hari,
                    ]);
                }
            }
    
            // Hapus jadwal yang dipilih
            if (!empty($this->jadwalPelajaranToRemove)) {
                ModelJadwalPelajaran::whereIn('id', $this->jadwalPelajaranToRemove)->delete();
            }
    
            DB::commit();
    
            Notification::make()
                ->success()
                ->title('Berhasil')
                ->body('Jadwal pelajaran berhasil diperbarui.')
                ->send();
    
            // Refresh the table
            $this->dispatch('refresh-table');
        } catch (\Exception $e) {
            DB::rollBack();
    
            Notification::make()
                ->danger()
                ->title('Gagal')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->send();
        }
    }

    public function mount()
    {
        $this->form->fill();
    }
}