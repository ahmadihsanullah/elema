<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Pengumpulan Tugas
        </x-slot>
        {{ $this->form }}
        <x-filament::button color="primary" wire:click="save" class="mt-6">
                Simpan
            </x-filament::button>
    </x-filament::section>
    <x-filament::section>
        <x-slot name="heading">
            File Tugas
        </x-slot>
        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>