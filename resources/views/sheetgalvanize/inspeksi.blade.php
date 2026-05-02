<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Inspeksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('sheetgalvanize.inspeksi.store', $sheetgalvanize->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Tebal -->
                    <div class="mb-4">
                        <label>Tebal</label>
                        <input type="number" name="tebal" class="w-full border rounded px-3 py-2" required autofocus>
                    </div>
                    <!-- Coating -->
                    <div class="mb-4">
                        <label>Coating</label>
                        <input type="number" name="coating" class="w-full border rounded px-3 py-2">
                    </div>
                    <!-- Visual -->
                    <div class="mb-4">
                        <label for="visual" class="block mb-1">Visual</label>
                        <select name="visual" id="visual" class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Visual --</option>
                            <option value="OK" {{ old('visual') == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NG" {{ old('visual') == 'NG' ? 'selected' : '' }}>NG</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <x-input-label for="files" :value="__('Upload File')" />
                        <input id="files" name="files[]" type="file" accept="image/*" capture="environment"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>
                        @error('files')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror

                        @error('files.*')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('sheetgalvanize.show', $sheetgalvanize->id) }}"
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
