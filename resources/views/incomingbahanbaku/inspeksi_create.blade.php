<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Inspeksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('incomingbahanbaku.inspeksi.store', $incomingbahanbaku->id) }}" method="POST">
                    @csrf

                    <!-- No Koil -->
                    <div class="mb-4">
                        <label>No Koil</label>
                        <input type="text" name="no_koil" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Diameter -->
                    <div class="mb-4">
                        <label>Diameter</label>
                        <input type="number" step="0.01" name="diameter" class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- D1 D2 D3 -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label>D1</label>
                            <input type="number" step="0.01" name="d1" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label>D2</label>
                            <input type="number" step="0.01" name="d2" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label>D3</label>
                            <input type="number" step="0.01" name="d3" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <!-- Dimensi -->
                    <div class="mb-4">
                        <label>Dimensi</label>
                        <input type="text" name="dimensi" class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Visual -->
                    <div class="mb-4">
                        <label>Visual</label>
                        <input type="text" name="visual" class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('incomingbahanbaku.show', $incomingbahanbaku->id) }}"
                            class="px-4 py-2 bg-gray-300 rounded">
                            Batal
                        </a>

                        <button class="px-4 py-2 bg-blue-600 text-white rounded">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
