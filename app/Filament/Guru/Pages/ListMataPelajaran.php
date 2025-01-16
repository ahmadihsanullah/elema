<?php

namespace App\Filament\Guru\Pages;

use App\Models\GuruMataPelajaran;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\TahunPelajaran;
use App\Models\JadwalPelajaran;

class ListMataPelajaran extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $title = 'Mata Pelajaran Saya';

    protected static string $view = 'filament.guru.pages.list-mata-pelajaran';

    public $mataPelajaran = [];

    public function mount()
    {
        $guru = Auth::user();
        $tahunPelajaranAktif = TahunPelajaran::where('aktif', true)->first();

        $this->mataPelajaran = GuruMataPelajaran::where('id_guru', $guru->id)
            ->with(['mataPelajaran', 'jadwalPelajaran.kelas'])
            ->get()
            ->flatMap(function ($guruMataPelajaran) use ($tahunPelajaranAktif) {
                return $guruMataPelajaran->jadwalPelajaran
                    ->where('id_tahun_pelajaran', $tahunPelajaranAktif->id)
                    ->map(function ($jadwal) use ($guruMataPelajaran) {
                        return [
                            'id' => $jadwal->id,
                            'mata_pelajaran' => $guruMataPelajaran->mataPelajaran->nama,
                            'kelas' => $jadwal->kelas->nama,
                            'hari' => $jadwal->hari,
                        ];
                    });
            })
            // Group by mata pelajaran and kelas
            ->groupBy(['mata_pelajaran', 'kelas'])
            ->map(function ($kelasGroups, $mataPelajaran) {
                $result = [];
                foreach ($kelasGroups as $kelas => $items) {
                    $result[] = [
                        'id' => $items->first()['id'], // Use the first jadwal's ID
                        'mata_pelajaran' => $mataPelajaran,
                        'kelas' => $kelas,
                        'hari' => $items->pluck('hari')->unique()->implode(', '),
                        'jadwal_count' => $items->count()
                    ];
                }
                return $result;
            })
            // Flatten the nested array
            ->flatten(1)
            ->values()
            ->toArray();
    }
    public function pilihMataPelajaran($jadwalId)
    {
        // Nanti akan digunakan untuk navigasi ke halaman sesi
        // Redirect atau open modal untuk membuat sesi
    }
}