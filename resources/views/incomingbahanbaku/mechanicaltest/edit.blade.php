<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Mechanical Test
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('incomingbahanbaku.mechanical_test.update', $mechanicalTest->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nomor Koil -->
                    <div class="mb-4">
                        <label>Nomor Koil</label>
                        <input type="text" name="nomor_koil"
                            value="{{ old('nomor_koil', $mechanicalTest->nomor_koil) }}"
                            class="w-full border rounded px-3 py-2" required autofocus>
                    </div>

                    <!-- Hasil Tensile -->
                    <div class="mb-4">
                        <label>Hasil Tensile</label>
                        <input type="number" step="0.01" name="hasil_tensile"
                            value="{{ old('hasil_tensile', $mechanicalTest->hasil_tensile) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Hasil Coating Weight -->
                    <div class="mb-4">
                        <label>Hasil Coating Weight (g/m<sup>2</sup>)</label>
                        <input type="number" step="0.01" name="hasil_coatingweight"
                            value="{{ old('hasil_coatingweight', $mechanicalTest->hasil_coatingweight) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Hasil Lilit -->
                    <div class="mb-4">
                        <label for="hasil_lilit">Hasil Lilit</label>

                        <select id="hasil_lilit" name="hasil_lilit" class="w-full border rounded px-3 py-2">

                            <option value="">-- Pilih Hasil Lilit --</option>

                            <option value="OK"
                                {{ old('hasil_lilit', $mechanicalTest->hasil_lilit) == 'OK' ? 'selected' : '' }}>
                                OK
                            </option>

                            <option value="CRACK"
                                {{ old('hasil_lilit', $mechanicalTest->hasil_lilit) == 'CRACK' ? 'selected' : '' }}>
                                CRACK
                            </option>

                        </select>
                    </div>

                    <!-- Hasil Puntir -->
                    <div class="mb-4">
                        <label>Hasil Puntir</label>

                        <input type="number" step="0.01" name="hasil_puntir"
                            value="{{ old('hasil_puntir', $mechanicalTest->hasil_puntir) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="flex justify-end gap-2">

                        <a href="{{ route('incomingbahanbaku.show', $mechanicalTest->incoming_bahan_baku_id) }}"
                            class="px-4 py-2 bg-gray-300 rounded">
                            Batal
                        </a>

                        <button class="px-4 py-2 bg-blue-600 text-white rounded">
                            Update
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
