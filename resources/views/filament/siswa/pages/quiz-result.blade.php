<!-- filepath: resources/views/filament/siswa/pages/quiz-result.blade.php -->
<x-filament::page>
    <div class="container mx-auto p-4">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Hasil Kuis: {{ $hasilKuis->kuis->judul }}</h2>
            <p class="text-lg mb-4 text-gray-900 dark:text-gray-100">Skor Anda: <span class="font-semibold">{{ $hasilKuis->skor }}</span> dari <span class="font-semibold">{{ $hasilKuis->kuis->pertanyaans->sum('bobot') }}</span> poin</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Jawaban Anda:</h3>
            <ul class="space-y-4">
                @foreach ($jawabanSiswa as $jawaban)
                    <li class="p-4 rounded-lg shadow-sm bg-gray-100 p-4 rounded-lg shadow-sm dark:bg-gray-900">
                        <strong class="block text-lg text-gray-900 dark:text-gray-100">{{ $jawaban->pertanyaan->pertanyaan }}</strong>
                        <p class="mt-2 text-gray-900 dark:text-gray-100">Jawaban Anda: <span class="font-semibold">{{ $jawaban->jawaban->jawaban }}</span></p>
                        @if ($jawaban->jawaban->jawaban_benar)
                        <span class="text-green-600 font-semibold">Jawaban Benar</span>
                    @else
                        <span class="text-red-600 font-semibold">Jawaban Salah</span>
                    @endif
                        <p class="mt-2 text-gray-900 dark:text-gray-100"><strong>Bobot Nilai:</strong> {{ $jawaban->pertanyaan->bobot }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            <x-filament::button wire:click="backToSession" class="bg-blue-500 dark:bg-blue-400 text-white dark:text-gray-900">Selesai</x-filament::button>
        </div>
    </div>
</x-filament::page>