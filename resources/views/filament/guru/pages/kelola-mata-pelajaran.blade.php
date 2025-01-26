<x-filament-panels::page>
    <x-filament::section>
           <p>{{ $mataPelajaran }}</p> 
    </x-filament::section>
    <x-filament::section>
        <x-slot name="heading">
            Tambah Sesi Pelajaran
        </x-slot>

        {{ $this->form }}

        <x-filament::button color="primary" wire:click="save" class="mt-6">
            Simpan
        </x-filament::button>
    </x-filament::section>

     <x-filament::section class="mt-6">
         <x-slot name="heading"> 
             Daftar Sesi Belajar
         </x-slot> 
         {{ $this->table }} 
     </x-filament::section>  
</x-filament-panels::page>