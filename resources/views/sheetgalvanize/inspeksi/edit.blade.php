<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Inspeksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('sheetgalvanize.inspeksi.update', $inspeksi->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Coating -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label>Coating 1</label>
                            <input type="number" step="0.01" name="coating1" value="{{ old('coating1', $inspeksi->coating1) }}"
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label>Coating 2</label>
                            <input type="number" step="0.01" name="coating2" value="{{ old('coating2', $inspeksi->coating2) }}"
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label>Coating 3</label>
                            <input type="number" step="0.01" name="coating3" value="{{ old('coating3', $inspeksi->coating3) }}"
                                class="w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label>Lebar</label>
                            <input type="number" step="0.01" name="lebar" value="{{ old('lebar', $inspeksi->lebar) }}"
                                class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label>Weight</label>
                            <input type="number" step="0.01" name="weight" value="{{ old('weight', $inspeksi->weight) }}"
                                class="w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="mb-4">
                            <label>Tebal</label>
                            <input type="number" step="0.01" name="tebal" value="{{ old('tebal', $inspeksi->tebal) }}"
                                class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="visual" class="block mb-1">Visual</label>
                            <select name="visual" id="visual" class="w-full border rounded px-3 py-2">
                                <option value="">-- Pilih Visual --</option>
                                <option value="OK" {{ old('visual', $inspeksi->visual) == 'OK' ? 'selected' : '' }}>
                                    OK</option>
                                <option value="NG" {{ old('visual', $inspeksi->visual) == 'NG' ? 'selected' : '' }}>
                                    NG</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="files" :value="__('Upload File')" />

                        <input id="files" name="files[]" type="file" accept="image/*,.pdf"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>

                        @error('files')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror

                        @error('files.*')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror

                        <!-- Preview file lama -->
                        @if ($inspeksi->files)
                            <div class="mt-4 flex flex-wrap gap-3">
                                @foreach ($inspeksi->files as $file)
                                    @php
                                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                        <img src="{{ asset('storage/' . $file) }}" alt="Inspeksi File"
                                            class="w-24 h-24 object-cover rounded border" />
                                    @else
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                            class="text-sm text-blue-600 hover:underline">
                                            Lihat File ({{ strtoupper($ext) }})
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>


                    <div class="flex justify-end gap-2">
                        <a href="{{ route('sheetgalvanize.show', $inspeksi->id) }}"
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
