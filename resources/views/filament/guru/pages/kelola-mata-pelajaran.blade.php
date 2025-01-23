<x-filament-panels::page>
    <div>
        <h1 class="text-2xl font-bold mb-4">Kelola Mata Pelajaran:</h1>

        <div class="mb-6">
            <h2 class="text-xl font-semibold">Sesi</h2>
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">Nama Sesi</th>
                        <th class="border border-gray-300 p-2">Tanggal</th>
                        <th class="border border-gray-300 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($mataPelajaran->sesi as $sesi)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $sesi->nama }}</td>
                            <td class="border border-gray-300 p-2">{{ $sesi->tanggal }}</td>
                            <td class="border border-gray-300 p-2">
                                <a href="{{ route('filament.guru.pages.edit-sesi', $sesi->id) }}" class="text-blue-500">Edit</a>
                                <a href="{{ route('filament.guru.pages.delete-sesi', $sesi->id) }}" class="text-red-500">Hapus</a>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>

        <div>
            <h2 class="text-xl font-semibold">Tambah Sesi Baru</h2>
            {{-- <form action="{{ route('filament.guru.pages.store-sesi') }}" method="POST">
                @csrf
                <input type="text" name="nama" placeholder="Nama Sesi" required class="border p-2 mb-2 w-full" />
                <input type="date" name="tanggal" required class="border p-2 mb-2 w-full" />
                <button type="submit" class="bg-blue-500 text-white p-2">Tambah Sesi</button>
            </form> --}}
        </div>
    </div>
</x-filament-panels::page>