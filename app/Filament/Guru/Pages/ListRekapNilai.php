<?php
namespace App\Filament\Guru\Pages;

use App\Models\GuruMataPelajaran;
use App\Models\HasilKuis;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use Filament\Pages\Page;

class ListRekapNilai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.guru.pages.list-rekap-nilai';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    protected static ?string $slug = 'list-rekap-nilai/{slug}';

    public $guruMapel;
    public $idKelas;
    public $siswaNilai = [];

    public function mount($slug)
    {
        // Mengambil data GuruMataPelajaran beserta relasi ke sesiBelajar
        $this->guruMapel = GuruMataPelajaran::query()
            ->where('slug', $slug)
            ->with([
                'mataPelajaran',
                 'sesiBelajar.kuis',
                  ]) // Tambahkan eager load relasi tugas dan kuis
            ->firstOrFail();

        // Ambil ID Kelas dari query string dan cek apakah kelas ditemukan
        $this->idKelas = request()->query('kelas');
        $kelas = Kelas::findOrFail($this->idKelas);

        // Inisialisasi list nilai siswa
        $listNilaiSiswa = [];

        // Ambil daftar siswa dalam kelas
        $siswaList = Siswa::where('id_kelas', $kelas->id)->get();

        foreach ($siswaList as $siswa) {
            $nilaiSiswa = [
                'nama_siswa' => $siswa->name,
                'nilai_sesi' => [], // Untuk menyimpan nilai tugas dan kuis per sesi
            ];
        
            foreach ($this->guruMapel->sesiBelajar as $sesi) {
                // Ambil semua tugas dari sesi ini
                $tugasList = $sesi->tugas()->get(); // Ambil semua tugas dari sesi (jika ada)
                $nilaiTugasSiswa = 0; // Default nilai 0
        
                if ($tugasList->isNotEmpty()) {
                    foreach ($tugasList as $tugas) {
                        // Ambil nilai tugas untuk siswa dari PengumpulanTugas
                        $nilaiTugas = PengumpulanTugas::where('id_siswa', $siswa->id)
                            ->where('id_tugas', $tugas->id)
                            ->first();
        
                        // Jika nilai tugas siswa bukan 0, maka ambil nilai tersebut
                        if (optional($nilaiTugas)->nilai > 0) {
                            $nilaiTugasSiswa = $nilaiTugas->nilai;
                            break; // Berhenti setelah menemukan nilai yang bukan 0
                        }
                    }
                }else{
                    $nilaiTugasSiswa = "tidak tersedia";
                }
        
                // Ambil nilai kuis dari relasi BelongsToMany (pivot)
                $nilaiKuis = null;
                if($sesi->kuis->isNotEmpty()) {
                    foreach ($sesi->kuis as $kuis) {
                        // Ambil hasil kuis untuk siswa tertentu
                            $hasilKuis = $kuis->hasilKuis()->where('id_siswa', $siswa->id)->first();
                            if ($hasilKuis) {
                                $nilaiKuis = $hasilKuis->skor; // Jika ditemukan, ambil nilai kuis siswa
                                break; // Keluar dari loop setelah menemukan hasil kuis
                            }else{
                                $nilaiKuis = 0;
                            }
                    }
                }else{
                    $nilaiKuis = "tidak tersedia";
                }

        
                // Masukkan nilai tugas dan kuis ke dalam array
                $nilaiSiswa['nilai_sesi'][] = [
                    'sesi' => $sesi->nama_sesi,  // Nama sesi belajar
                    'nilai_tugas' => $nilaiTugasSiswa, // Nilai tugas (jika ada tugas yang nilainya bukan 0)
                    'nilai_kuis' => $nilaiKuis, // Nilai kuis (jika ada)
                ];
            }
        
            // Tambahkan ke list nilai siswa
            $listNilaiSiswa[] = $nilaiSiswa;
        }
        
        // Simpan list nilai siswa ke dalam properti kelas
        $this->siswaNilai = $listNilaiSiswa;
        
    }
}