<!-- filepath: resources/views/filament/guru/pages/view-quiz-result.blade.php -->
<x-filament::page>
    <x-filament::card>
        
        <p class="text-2xl font-bold mb-4">Daftar Siswa yang menyelesaikan kuis:  {{ $kuis->judul }}</p>
        <p class="text-gray-500 mb-4">Created at: {{ $kuis->created_at }}</p>
        
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="text-left py-3 px-6 border-r">No</th>
                        <th class="text-left py-3 px-6 border-r">Nama</th>
                        <th class="text-left py-3 px-6 border-r">Kelas</th>
                        <th class="text-left py-3 px-6">Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hasilKuis as $hk)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6 border-r">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6 border-r">{{ $hk->siswa->name }}</td>
                            <td class="py-3 px-6 border-r">{{ $hk->siswa->kelas->nama }}</td>
                            <td class="py-3 px-6">{{ $hk->skor }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::card>
</x-filament::page>
