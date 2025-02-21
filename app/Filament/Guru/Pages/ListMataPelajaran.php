<?php

namespace App\Filament\Guru\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\TahunPelajaran;
use App\Models\JadwalPelajaran;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class ListMataPelajaran extends Page implements HasActions
{
    use InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $title = 'Mata Pelajaran';

    protected static string $view = 'filament.guru.pages.list-mata-pelajaran';

    public $mataPelajaran = [];

    public function mount()
    {
        $guru = Auth::user();

        try {
            // Ambil tahun pelajaran aktif dengan error handling
            $tahunPelajaranAktif = TahunPelajaran::where('aktif', true)->first();
            if (!$tahunPelajaranAktif) {
                throw new \Exception("Tahun pelajaran aktif tidak ditemukan!");
            }

            // Query dengan select untuk optimasi
            $jadwalByMataPelajaran = JadwalPelajaran::where('id_tahun_pelajaran', $tahunPelajaranAktif->id)
                ->whereHas('guruMataPelajaran', function ($query) use ($guru) {
                    $query->where('id_guru', $guru->id);
                })
                ->with([
                    'guruMataPelajaran' => function ($query) {
                        $query->select('id', 'id_guru', 'id_mata_pelajaran', 'slug')
                            ->with([
                                'mataPelajaran:id,nama',
                                'guru:id,name'
                            ]);
                    },
                    'kelas:id,nama'
                ])
                ->get()
                ->groupBy('guruMataPelajaran.mataPelajaran.id');

            // Transform data
            $this->mataPelajaran = $jadwalByMataPelajaran->map(function ($jadwals) {
                $firstJadwal = $jadwals->first();
                $mataPelajaran = $firstJadwal->guruMataPelajaran->mataPelajaran;
                $guru = $firstJadwal->guruMataPelajaran->guru;
                return [
                    'slug_guru_mapel' => $firstJadwal->guruMataPelajaran->slug,
                    'mata_pelajaran_id' => $mataPelajaran->id,
                    'mata_pelajaran' => $mataPelajaran->nama,
                    'guru' => $guru->name,
                    'jadwals' => $jadwals->map(function ($jadwal) {
                        return [
                            'jadwal_id' => $jadwal->id,
                            'kelas' => $jadwal->kelas->nama,
                            'hari' => $jadwal->hari,
                        ];
                    })
                ];
            })->values();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function KelolaJadwal($slugGuruMapel)
    {
        return redirect()->route('filament.guru.pages.mata-pelajaran.{slugGuruMapel}', ['slugGuruMapel' => $slugGuruMapel]);
    }
}
