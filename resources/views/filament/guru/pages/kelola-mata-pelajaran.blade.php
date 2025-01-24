{{-- <x-filament-panels::page>
    <div class="space-y-4">

        <!-- Tombol untuk menambah sesi -->
        <div class="mb-4">
            <button class="bg-green-500 dark:bg-green-700 dark:text-white px-4 py-2 rounded" onclick="showAddSessionForm()">
                Tambah Sesi
            </button>
        </div>

        <!-- mata pelajaran -->
        <div class="border border-gray-300 dark:border-gray-600 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Mata Pelajaran: Matematika</h2>
            <div class="flex justify-between items-center">
                <button class="text-blue-500" onclick="toggleDropdown('dropdownMath')">▼</button>
            </div>
            <div id="dropdownMath" class="hidden mt-2">
                <button class="bg-green-500 dark:text-white  px-2 py-1 rounded">Tambah Materi</button>
                <button class="bg-yellow-500 dark:text-white px-2 py-1 rounded">Tambah Tugas</button>
                <button class="bg-blue-500 dark:text-white px-2 py-1 rounded">Lihat Materi</button>
                <button class="bg-orange-500 dark:text-white px-2 py-1 rounded">Edit Sesi</button>
                <button class="bg-red-500 dark:text-white px-2 py-1 rounded">Hapus Sesi</button>
            </div>
        </div>

        <!-- Tambahkan mata pelajaran lainnya -->
    </div>

    <script>
        function toggleDropdown(dropdownId) {
            console.log("Toggling dropdown: " + dropdownId); // Debugging
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }
    </script>
</x-filament-panels::page> --}}

<x-filament-panels::page>
    <div class="space-y-4">
        <!-- Tombol untuk menambah sesi -->
        <div class="mb-4">
            <button class="bg-yellow-500 dark:bg-yellow-700 dark:text-white px-4 py-2 rounded" onclick="showAddSessionForm()">
                Tambah Sesi
            </button>
        </div>

        <!-- Daftar sesi -->
        <div class="border border-gray-300 dark:border-gray-600 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Mata Pelajaran: {{ $mataPelajaran }}</h2>
            <div class="flex justify-between items-center">
                <button class="text-blue-500" onclick="toggleDropdown('dropdownMath')">▼</button>
            </div>
            <div id="dropdownMath" class="hidden mt-2">
                <button class="bg-green-500 dark:bg-green-600 dark:text-white px-2 py-1 rounded">Tambah Materi</button>
                <button class="bg-yellow-500 dark:bg-yellow-600 dark:text-white px-2 py-1 rounded">Tambah Tugas</button>
                <button class="bg-blue-500 dark:bg-blue-700 dark:text-white px-2 py-1 rounded">Lihat Materi</button>
                <button class="bg-orange-500 dark:bg-orange-600 dark:text-white px-2 py-1 rounded">Edit Sesi</button>
                <button class="bg-red-500 dark:bg-red-700 dark:text-white px-2 py-1 rounded">Hapus Sesi</button>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(dropdownId) {
            console.log("Toggling dropdown: " + dropdownId); // Debugging
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }

        function showAddSessionForm() {
            alert("Form untuk menambah sesi akan ditampilkan.");
        }
    </script>
</x-filament-panels::page>