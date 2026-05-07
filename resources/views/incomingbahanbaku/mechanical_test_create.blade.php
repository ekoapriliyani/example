<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Mechanical Test
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('incomingbahanbaku.mechanical_test.store', $incomingbahanbaku->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- No Koil -->
                    <div class="mb-4">
                        <label>Nomor Koil</label>
                        <input type="text" name="nomor_koil" class="w-full border rounded px-3 py-2" required
                            autofocus>
                    </div>
                    <!-- Hasil Tensile -->
                    <div class="mb-4">
                        <label>Hasil Tensile</label>
                        <input type="number" name="hasil_tensile" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <!-- Hasil Coating Weight -->
                    <div class="mb-4">
                        <label>Hasil Coating Weight</label>
                        <input type="number" name="hasil_coatingweight" class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                    <!-- Hasil Lilit -->
                    <div class="mb-4">
                        <label for="hasil_lilit">Hasil Lilit</label>
                        <select id="hasil_lilit" name="hasil_lilit" class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Hasil Lilit --</option>
                            <option value="OK" {{ old('hasil_lilit') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="CRACK" {{ old('hasil_lilit') == 'CRACK' ? 'selected' : '' }}>CRACK</option>
                        </select>
                    </div>

                    <!-- Hasil Puntir -->
                    <div class="mb-4">
                        <label>Hasil Puntir</label>
                        <input type="number" step="0.01" name="hasil_puntir" class="w-full border rounded px-3 py-2"
                            required>
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
