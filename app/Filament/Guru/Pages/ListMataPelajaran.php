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

class ListMataPelajaran extends Page implements HasActions
{
    use InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    
    protected static ?string $title = 'Mata Pelajaran Saya';
    
    protected static string $view = 'filament.guru.pages.list-mata-pelajaran';

    public $mataPelajaran = [];

    public function mount()
    {
        $guru = Auth::user();
        $tahunPelajaranAktif = TahunPelajaran::where('aktif', true)->first();

        // Kelompokkan jadwal berdasarkan mata pelajaran
        $jadwalByMataPelajaran = JadwalPelajaran::where('id_tahun_pelajaran', $tahunPelajaranAktif->id)
            ->whereHas('guruMataPelajaran', function($query) use ($guru) {
                $query->where('id_guru', $guru->id);
            })
            ->with([
                'guruMataPelajaran.mataPelajaran', 
                'guruMataPelajaran.guru', 
                'kelas'
            ])
            ->get()
            ->groupBy('guruMataPelajaran.mataPelajaran.id');

        // Transform data untuk view
        $this->mataPelajaran = $jadwalByMataPelajaran->map(function($jadwals) {
            // Ambil informasi mata pelajaran dari jadwal pertama di group
            $firstJadwal = $jadwals->first();
            $mataPelajaran = $firstJadwal->guruMataPelajaran->mataPelajaran;
            $guru = $firstJadwal->guruMataPelajaran->guru;

            return [
                'mata_pelajaran_id' => $mataPelajaran->id,
                'mata_pelajaran' => $mataPelajaran->nama,
                'guru' => $guru->name,
                'jadwals' => $jadwals->map(function($jadwal) {
                    return [
                        'jadwal_id' => $jadwal->id,
                        'kelas' => $jadwal->kelas->nama,
                        'hari' => $jadwal->hari,
                    ];
                })
            ];
        })->values();
    }

    public function kelolaMataPelajaran($mataPelajaranId)
{
    return Action::make('kelolaMataPelajaran')
        ->label('Kelola Mata Pelajaran')
        ->color('primary')
        ->action(function () use ($mataPelajaranId) {
            // Redirect ke halaman detail mata pelajaran dengan parameter ID
            return redirect()->route('filament.guru.pages.detail-mata-pelajaran', ['mataPelajaranId' => $mataPelajaranId]);
        });
}
}