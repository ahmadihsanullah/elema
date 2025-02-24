<?php

namespace App\Imports;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Maatwebsite\Excel\Concerns\ToModel;

class PertanyaansImport implements ToModel
{
    private $idKuis;
    public function __construct($idKuis)
    {
        $this->idKuis = $idKuis;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Membuat Pertanyaan baru
        $pertanyaan = Pertanyaan::create([
            'id_kuis' => $this->idKuis, // Relasi ke id_kuis
            'pertanyaan' => $row[0], // Kolom pertama sebagai pertanyaan
            'bobot' => $row[1],      // Kolom kedua sebagai bobot
        ]);

        // Memproses jawaban dan status benar/salah
        $jawabanDanStatus = [];
        for ($i = 2; $i <= count($row) - 1; $i += 2) {
            $jawaban = $row[$i];
            $statusBenar = $row[$i + 1]; // Pastikan bahwa $data[$i + 1] adalah 0 atau 1

            $jawabanDanStatus[] = [
                'jawaban' => $jawaban,
                'jawaban_benar' => $statusBenar // Pastikan status benar disimpan sebagai integer
            ];
        }
        // Simpan ke database
        foreach ($jawabanDanStatus as $item) {
            Jawaban::create([
                'id_pertanyaan' => $pertanyaan->id,  // Id pertanyaan yang terkait
                'jawaban' => $item['jawaban'],     // Isi jawaban
                'jawaban_benar' => $item['jawaban_benar'], // 0 atau 1, apakah jawaban benar?
            ]);
        }
    }
    // Fungsi untuk membuat jawaban
    protected function createJawaban($pertanyaan, $jawaban, $isCorrect)
    {
        Jawaban::create([
            'id_pertanyaan' => $pertanyaan->id,  // Relasi ke id_pertanyaan
            'jawaban' => $jawaban,                // Isi jawaban
            'jawaban_benar' => $isCorrect, // Apakah jawaban benar?
        ]);
    }
}
