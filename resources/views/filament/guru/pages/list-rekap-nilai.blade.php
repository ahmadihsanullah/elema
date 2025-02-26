<x-filament::page>
    <div class="space-y-4">
        <h2 class="text-2xl font-bold">Rekap Nilai - {{ $guruMapel->mataPelajaran->nama }}</h2>
        
        @if(!empty($siswaNilai))
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Nama Siswa</th>
                            @foreach ($guruMapel->sesiBelajar as $sesi)
                                <th class="px-4 py-2 text-center">Tugas ({{ $sesi->judul }})</th>
                                <th class="px-4 py-2 text-center">Kuis ({{ $sesi->judul }})</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswaNilai as $nilaiSiswa)
                            <tr>
                                <td class="border px-4 py-2">{{ $nilaiSiswa['nama_siswa'] }}</td>
                                @foreach ($nilaiSiswa['nilai_sesi'] as $nilai)
                                    <td class="border px-4 py-2 text-center">{{ $nilai['nilai_tugas'] }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $nilai['nilai_kuis'] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Tidak ada data nilai yang ditemukan.</p>
        @endif
    </div>
</x-filament::page>
