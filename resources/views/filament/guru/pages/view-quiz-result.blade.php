<!-- filepath: resources/views/filament/guru/pages/view-quiz-result.blade.php -->
<x-filament::page>
    <div>
        <x-filament::link wire:click="backToSession" tag="button">
            Kembali
        </x-filament::link>
    </div>
    <x-filament::card>
        <p class="text-xl text-black-700 mb-4">Daftar Siswa yang menyelesaikan kuis:  {{ $kuis->judul }}</p>
        <div class="overflow-x-auto">
            {{$this->table}}
        </div>
    </x-filament::card>
</x-filament::page>
