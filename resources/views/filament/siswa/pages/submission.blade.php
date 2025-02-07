<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Info Tugas
        </x-slot>
        <table>
            <tr>
                <td>Nama Tugas</td>
                <td>:</td>
                <td>{{ $tugas->judul }}</td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td>{!! $tugas->deskripsi !!}</td>
            </tr>
            <tr>
                <td>Deadline Pengumpulan</td>
                <td>:</td>
                <td>{{ $tugas->deadline }}</td>
            </tr>
        </table>
    </x-filament::section>

    @if ($this->pengumpulanTugas == null)
        <x-filament::section>
            <x-slot name="heading">
                Upload Tugas
            </x-slot>
            {{ $this->form }}
            <x-filament::button color="primary" wire:click="save" class="mt-6">
                Simpan
            </x-filament::button>
        </x-filament::section>
    @else
        <x-filament::section>
            <x-slot name="heading">
                Pengumpulan Tugas
                <div class="float-left mt-2">
                    <x-filament::button color="warning" wire:click="edit('{{ $this->pengumpulanTugas->slug }}')">
                        Edit
                    </x-filament::button>
                    <x-filament::button color="danger" wire:click="delete">
                        Hapus
                    </x-filament::button>
                </div>
               
            </x-slot>

            <table>
                <tr>
                    <td>Status Pengumpulan </td>
                    <td> : </td>
                    <td>{{ $this->pengumpulanTugas->status_pengumpulan }}</td>
                </tr>
                <tr>
                    <td>Waktu Pengumpulan </td>
                    <td> : </td>
                    <td>{{ $this->pengumpulanTugas->created_at->diffForHumans() }}</td>
                </tr>
                <tr>
                    <td>Sisa Waktu </td>
                    <td> : </td>
                    <td>
                        @php
                            $deadline = \Carbon\Carbon::parse($tugas->deadline);
                            $createdAt = \Carbon\Carbon::parse($this->pengumpulanTugas->created_at);
                            $remainingTime = $deadline->diffForHumans($createdAt, true); // Menghitung sisa waktu
                            $isLate = $createdAt > $deadline; // Mengecek jika terlambat
                            $lateDuration = $createdAt->diff($deadline); // Durasi keterlambatan
                        @endphp

                        @if ($isLate)
                            <span class="text-red-500 font-bold">
                                Terlambat {{ $lateDuration->format('%d hari %h jam %i menit') }}
                            </span>
                        @else
                            {{ $remainingTime }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="border px-4 py-2 text-center">File </td>
                </tr>
                <tr>
                    <td colspan="3" class="border px-4 py-2">
                        @if ($this->pengumpulanTugas->filePengumpulanTugas->count() < 2)
                            @php
                                $filePengumpulan = $this->pengumpulanTugas->filePengumpulanTugas->first();
                            @endphp
                            <a href="{{ Storage::url($filePengumpulan->file) }}"
                                class="text-blue-500 hover:underline" target="_blank">
                                {{ $filePengumpulan->nama_file }}
                            </a>
                        @elseif ($this->pengumpulanTugas->filePengumpulanTugas->count() > 1)
                            <ul>
                                @foreach ($this->pengumpulanTugas->filePengumpulanTugas as $file)
                                    <li>
                                        - <a href="{{ Storage::url($file->file) }}"
                                            class="text-blue-500 hover:underline" target="_blank">
                                            {{ $file->nama_file }}
                                        </a>
                                        <br>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    
                </tr>
            </table>
        </x-filament::section>
    @endif
</x-filament-panels::page>
