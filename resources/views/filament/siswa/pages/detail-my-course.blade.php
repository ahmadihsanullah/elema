<x-filament-panels::page>
    <div>
        <x-filament::link :href="route('filament.siswa.pages.dashboard')" color="info">
            Kembali
        </x-filament::link>
    </div>
            @foreach ($sesiBelajars as $sesiBelajar)
            <x-filament::section  icon="heroicon-o-clipboard-document-list" icon-color="info">
                <x-slot name="heading">
                    {{ $sesiBelajar['judul'] }}
                </x-slot>
                {{-- Content --}}
                <x-filament::button color="primary" wire:click="sesiBelajar('{{ $sesiBelajar['slug'] }}')" class="ml-auto">
                    Lihat Sesi
                </x-filament::button>
               
            </x-filament::section>
        @endforeach
       
</x-filament-panels::page>
