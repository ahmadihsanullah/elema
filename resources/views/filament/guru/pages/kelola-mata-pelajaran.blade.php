<x-filament-panels::page>
    <x-filament::section>
        <h2>{{ $mataPelajaran }}</h2>
    </x-filament::section>

    <x-filament::modal id="tambah-sesi-modal">
        <x-slot name="trigger">
            <x-filament::button>
                + Tambah Sesi
            </x-filament::button>
        </x-slot>

        <x-slot name="heading">
            Tambah Sesi Pelajaran
        </x-slot>

        {{ $this->form }}

        <x-filament::button color="primary" wire:click="save" class="mt-6">
            Simpan
        </x-filament::button>
    </x-filament::modal>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Daftar Sesi Belajar
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
           {{$this->table}}
        </div>
    </x-filament::section>
</x-filament-panels::page>

