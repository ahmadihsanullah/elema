<x-filament-panels::page>
    <div class="grid grid-cols-12 gap-6">
        <!-- Bagian Materi -->
        <div class="col-span-12">
            <x-filament::section>
                <x-slot name="heading">
                    <h2 class="text-xl font-semibold">Materi</h2>
                </x-slot>
                @if ($materi)
                    <x-slot name="heading">
                        <h1 class="text-2xl font-bold">{{ $materi->judul }}</h1>
                    </x-slot>
                    <div class="prose max-w-none">
                        {!! $materi->deskripsi !!}
                    </div>
                @else
                    <p>Materi tidak ditemukan</p>
                @endif
            </x-filament::section>
        </div>

        <!-- Bagian File Materi -->
        <div class="col-span-6 border border-blue-500">
            <x-filament::section>
                <x-slot name="heading">
                    <h2 class="text-xl font-semibold">File Materi</h2>
                </x-slot>
                @if ($fileMateri)
                    @foreach($fileMateri as $file)
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <button class="font-medium flex items-center space-x-2" wire:click="downloadFile('{{ $file->file }}')">
                                <x-heroicon-o-document class="mx-3 w-5 h-5 text-gray-500" />
                                <span>{{ $file->nama }}</span>
                            </button>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada file materi untuk sesi ini.</p>
                @endif
            </x-filament::section>
        </div>

       
        <!-- Tabel Tugas -->
        <div class="col-span-12">
            <x-filament::section>
                <x-slot name="heading">
                    <h2 class="text-xl font-semibold">Daftar Tugas</h2>
                </x-slot>
                
                @if ($tugas->count() > 0)
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="border">
                                <th class="border px-4 py-2">Judul Tugas</th>
                                <th class="border px-4 py-2">Pengumpulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugas as $t)
                                <tr>
                                    <td class="border px-4 py-2">{{ $t->judul . '- '. $t->id }}</td>
                                    <td class="border px-4 py-2">
                                        <button
                                            wire:click="kumpulkanTugas('{{ $t->id }}')"
                                            class="text-blue-500"
                                        >
                                            Kumpulkan Tugas
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">Belum ada tugas yang di-upload.</p>
                @endif
            </x-filament::section>
        </div>

        <!-- Bagian Kuis -->
        <div class="col-span-6 border border-blue-500">
            <x-filament::section>
                <x-slot name="heading">
                    <h2 class="text-xl font-semibold">Kuis</h2>
                </x-slot>
                @if ($kuis->count() > 0)
                    @foreach($kuis as $k)
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <h3 class="font-medium">{{ $k->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $k->deskripsi }}</p>
                            <p class="mb-4">Mulai: <strong>{{ \Carbon\Carbon::parse($k->mulai)->format('d M Y, H:i') }}</strong></p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada kuis untuk sesi ini.</p>
                @endif
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
