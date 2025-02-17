<?php

namespace App\Filament\Siswa\Pages;

use App\Models\GuruMataPelajaran;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MyCourses extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.siswa.pages.my-courses';
    public $mataPelajaran = [];

    protected static ?string $title = null;
    public $siswa;
    public $search = '';

    public function getMataPelajarans()
    {
        $siswa = $this->siswa;

        // Ambil tahun pelajaran aktif dengan error handling
        $tahunPelajaranAktif = TahunPelajaran::where('aktif', true)->first();
        if (!$tahunPelajaranAktif) {
            throw new \Exception("Tahun pelajaran aktif tidak ditemukan!");
        }

        // Query dengan select untuk optimasi
        $jadwalByMataPelajaran = JadwalPelajaran::where('id_tahun_pelajaran', $tahunPelajaranAktif->id)
            ->whereHas('guruMataPelajaran', function ($query) use ($siswa) {
                $query->where('id_kelas', $siswa->id_kelas);
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
            ->groupBy('guruMataPelajaran.id');

        // Transform data
        $this->mataPelajaran = $jadwalByMataPelajaran->map(function ($jadwals) {
            $firstJadwal = $jadwals->first();
            $guruMapel = $firstJadwal->guruMataPelajaran;
            return [
                'slug_mapel' => $guruMapel->slug,
                'mata_pelajaran' => $guruMapel->mataPelajaran->nama,
                'guru' => $guruMapel->guru->name,
                'jadwals' => $jadwals->map(function ($jadwal) {
                    return [
                        'jadwal_id' => $jadwal->id,
                        'kelas' => $jadwal->kelas->nama,
                        'hari' => $jadwal->hari,
                    ];
                })
            ];
        })->values();
    }

    public function searchMataPelajaran()
    {
        $siswa = $this->siswa;

        // Ambil tahun pelajaran aktif dengan error handling
        $tahunPelajaranAktif = TahunPelajaran::where('aktif', true)->first();
        if (!$tahunPelajaranAktif) {
            throw new \Exception("Tahun pelajaran aktif tidak ditemukan!");
        }

        // Query untuk pencarian mata pelajaran
        $jadwalByMataPelajaran = JadwalPelajaran::where('id_tahun_pelajaran', $tahunPelajaranAktif->id)
            ->whereHas('guruMataPelajaran', function ($query) use ($siswa) {
                $query->where('id_kelas', $siswa->id_kelas)
                      ->whereHas('mataPelajaran', function ($query) {
                          $query->where('nama', 'like', '%' . $this->search . '%');
                      });
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
            ->groupBy('guruMataPelajaran.id');

        // Transform data
        $this->mataPelajaran = $jadwalByMataPelajaran->map(function ($jadwals) {
            $firstJadwal = $jadwals->first();
            $guruMapel = $firstJadwal->guruMataPelajaran;
            return [
                'slug_mapel' => $guruMapel->slug,
                'mata_pelajaran' => $guruMapel->mataPelajaran->nama,
                'guru' => $guruMapel->guru->name,
                'jadwals' => $jadwals->map(function ($jadwal) {
                    return [
                        'jadwal_id' => $jadwal->id,
                        'kelas' => $jadwal->kelas->nama,
                        'hari' => $jadwal->hari,
                    ];
                })
            ];
        })->values();
    }

    public function getRecord(): ?Siswa
    {
        return Auth::guard('student')->user();
    }

    public function mount()
    {
        $this->siswa = $this->getRecord();
        $this->getMataPelajarans();
    }

    public function updatedSearch()
    {
        $this->searchMataPelajaran();
    }

    public function myCourse($slugMapel)
    {
        return redirect()->route('filament.siswa.pages.my-courses.{slugMapel}', ['slugMapel' => $slugMapel]);
    }
}
