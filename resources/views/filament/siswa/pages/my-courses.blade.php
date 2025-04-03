<x-filament-panels::page>
    <div class="flex justify-center mb-4">
        <div class="relative w-full max-w-lg flex items-center">
            <x-filament::input.wrapper class="w-full mr-2">
                <x-filament::input type="text" wire:model="search" placeholder="Cari mata pelajaran..." class="w-full" />
            </x-filament::input.wrapper>
            <x-filament::button class="ml-2" wire:click="searchMataPelajaran">
                Cari
            </x-filament::button>
        </div>
    </div>
    <div class="space-y-6">
        @if (count($mataPelajaran) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($mataPelajaran as $mapel)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                        <h3 class="text-lg font-medium mb-2 dark:text-white">{{ $mapel['mata_pelajaran'] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-white mb-4">Guru: {{ $mapel['guru'] }}</p>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                            <h4 class="text-sm font-medium mb-2 dark:text-white">Jadwal Kelas:</h4>
                            @foreach ($mapel['jadwals'] as $jadwal)
                                <div class="mb-2">
                                    <p class="text-sm dark:text-white">Kelas: {{ $jadwal['kelas'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-white">Hari: {{ $jadwal['hari'] }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <button wire:click="myCourse('{{ $mapel['slug_mapel'] }}')"
                                class="px-4 py-2 bg-primary-500 text-white rounded hover:bg-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 text-sm">
                                Lihat Mapel
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="dark:text-white">Tidak ada mata pelajaran yang sesuai</p>
        @endif
    </div>
</x-filament-panels::page>