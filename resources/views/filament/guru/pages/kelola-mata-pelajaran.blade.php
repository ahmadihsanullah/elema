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
    <x-slot name="heading">
        Daftar Sesi Belajar
    </x-slot>

    <div class="flex flex-wrap gap-4">
        @foreach ($sesiBelajar as $sesi)
            <x-filament::section  icon="heroicon-o-clipboard-document-list" icon-color="info">
                <x-slot name="heading">
                    {{ $sesi['judul'] }}
                </x-slot>
                {{-- Content --}}
                <x-filament::link color="primary" icon="heroicon-m-eye" :href="route('filament.guru.resources.sesi-belajars.edit', $sesi['slug'])">
                    Detail Sesi
                </x-filament::link>

                <x-filament::modal id="hapus-sesi-modal">
                    <x-slot name="trigger">
                        <x-filament::link color="danger" icon="heroicon-m-trash">
                            Hapus
                        </x-filament::link>
                    </x-slot>

                    <x-slot name="heading">
                        Hapus Sesi Pelajaran
                    </x-slot>
                    Apakah yakin ingin menghapus sesi {{ $sesi['judul'] }}?<br>

                    <x-filament::button color="danger" wire:click="deleteSesiBelajar('{{ $sesi['id'] }}')"
                        class="mt-6">
                        Ya
                    </x-filament::button>
                </x-filament::modal>
            </x-filament::section>
        @endforeach
    </div>
</x-filament-panels::page>
