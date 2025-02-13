<!-- filepath: resources/views/filament/siswa/pages/session.blade.php -->
<x-filament-panels::page>
    <div class="mb-4">
        <x-filament::link :href="route('filament.siswa.pages.my-courses.{slugMapel}', ['slugMapel' => $slugMapel])" color="info">
            Kembali
        </x-filament::link>
    </div>
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
                    <div class=" dark:tetx-white">
                        {!! $materi->deskripsi !!}
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Materi tidak ditemukan</p>
                @endif
            </x-filament::section>
        </div>

        <!-- Bagian File Materi -->
        <div class="col-span-6">
            <x-filament::section>
                <x-slot name="heading">
                    <h2 class="text-xl font-semibold">File Materi</h2>
                </x-slot>
                @if ($fileMateri)
                    @foreach ($fileMateri as $file)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                            <button class="font-medium flex items-center space-x-2"
                                wire:click="downloadFile('{{ $file->file }}')">
                                <x-heroicon-o-document class="mx-3 w-5 h-5 text-gray-500 dark:text-gray-400" />
                                <span class="text-gray-900 dark:text-gray-100">{{ $file->nama }}</span>
                            </button>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada file materi untuk sesi ini.</p>
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
                                    <td class="border px-4 py-2 text-gray-900 dark:text-gray-100">{{ $t->judul }}</td>
                                    <td class="border px-4 py-2">
                                        <button wire:click="kumpulkanTugas('{{ $t->id }}')" class="text-blue-500 dark:text-blue-400">
                                            Kumpulkan Tugas
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Belum ada tugas yang di-upload.</p>
                @endif
            </x-filament::section>
        </div>

         <!-- Bagian Kuis -->
        <div class="col-span-6">
            <x-filament::section>
                <x-slot name="heading">
                    <h2 class="text-xl font-semibold mb-4">Kuis</h2>
                </x-slot>

                @if ($kuis->count() > 0)
                    @foreach ($kuis as $k)
                        @if ($k->waktu_mulai && $k->waktu_selesai && now("Asia/Jakarta")->greaterThanOrEqualTo($k->waktu_mulai) && now("Asia/Jakarta")->lessThanOrEqualTo($k->waktu_selesai))
                            <x-filament::section class="mb-4">
                                <x-slot name="heading">
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $k->judul }}</h1>
                                </x-slot>
                                <div class="prose max-w-none dark:prose-dark">
                                    <p class="text-gray-900 dark:text-white">Deskripsi: {{ $k->deskripsi }}</p>
                                    <p class="text-gray-900 dark:text-white">Intruksi Kuis</p>
                                    <p class="text-gray-900 dark:text-white">Durasi: {{ $k->durasi }} menit</p>
                                    <p class="text-gray-900 dark:text-white">Jumlah Soal: {{ $k->pertanyaans()->count() }} soal</p>
                                    <p class="text-gray-900 dark:text-white">Petunjuk: Pastikan Anda mengerjakan semua soal dengan seksama. Waktu akan dimulai setelah Anda memulai kuis ini.</p>
                                    <p class="text-gray-900 dark:text-white">Waktu Mulai: {{ $k->waktu_mulai }}</p>
                                    <p class="text-gray-900 dark:text-white">Waktu Selesai: {{ $k->waktu_selesai }}</p>
                                </div>
                                <!-- Tombol untuk memulai kuis atau melihat hasil -->
                                @if (now()->lessThanOrEqualTo($k->waktu_selesai))
                                    <x-filament::button color="info" wire:click="startQuiz('{{ $k->slug }}')" class="mt-3">
                                        Mulai Kuis
                                    </x-filament::button>
                                @elseif ($k->hasilKuis)
                                    <x-filament::button color="info" wire:click="lihatHasil('{{ $k->slug }}')" class="mt-3">
                                        Lihat Hasil
                                    </x-filament::button>
                                @else
                                    <x-filament::button color="info" class="mt-3" disabled>
                                        Mulai Kuis
                                    </x-filament::button>
                                @endif
                            </x-filament::section>
                        @endif
                    @endforeach
                @else
                    <!-- Pesan Jika Tidak Ada Kuis -->
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada kuis untuk sesi ini.</p>
                @endif
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>