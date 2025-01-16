<x-filament-panels::page>
    <div class="space-y-6">
        <h2 class="text-md font-semibold dark:text-white">Mata Pelajaran yang Anda Ajar</h2>
        
        @if(count($mataPelajaran) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($mataPelajaran as $mapel)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-4">
                        <h3 class="text-lg font-medium mb-2 dark:text-white">{{ $mapel['mata_pelajaran'] }}</h3>
                        <p class="text-gray-600 dark:text-white">Kelas: {{ $mapel['kelas'] }}</p>
                        <p class="text-gray-600 dark:text-white">Hari: {{ $mapel['hari'] }}</p>
                        <button 
                            wire:click="pilihMataPelajaran({{ $mapel['id'] }})"
                            class="mt-3 px-4 py-2 bg-primary-500 text-white rounded hover:bg-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600"
                        >
                            Pilih Mata Pelajaran
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg text-center">
                <p class="text-gray-600 dark:text-gray-300">Anda belum memiliki mata pelajaran yang dijadwalkan.</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
