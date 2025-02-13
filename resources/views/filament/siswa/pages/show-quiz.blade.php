<x-filament::page>
    <div class="p-4">
        <!-- Judul Kuis -->
        <h2 class="text-2xl font-bold mb-2">{{ $kuis->judul }}</h2>

        <!-- Informasi Kuis -->
        <p class="text-gray-700">Durasi: {{ $durasi }} menit</p>
        <p class="text-gray-700">Jumlah Soal: {{ $jumlahSoal }} soal</p>

        <hr class="my-4">

        <!-- Form Kuis -->
        <div class="bg-white shadow-md rounded-lg p-6">
            {{ $this->form }}
        </div>

    </div>
</x-filament::page>
