<x-filament-panels::page>
    @foreach ($sesiBelajars as $sesiBelajar)
    <x-filament::section>
        <div class="flex justify-between items-center">
            <span>{{ $sesiBelajar->judul }}</span>
            <x-filament::button color="primary" wire:click="sesiBelajar('{{ $sesiBelajar['slug']  }}')" class="ml-auto">
                Lihat Sesi
            </x-filament::button>
        </div>
    </x-filament::section>
    @endforeach
</x-filament-panels::page>
