<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Inspeksi Incoming
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form
                    action="{{ route('incomingbahanbaku.inspeksi.update', [
                        'incomingbahanbaku' => $incomingbahanbaku->id,
                        'inspeksi' => $inspeksi->id,
                    ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <!-- No Koil -->
                    <div class="mb-4">
                        <label>No Koil</label>

                        <input type="text" name="no_koil" value="{{ old('no_koil', $inspeksi->no_koil) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- D1 -->
                    <div class="mb-4">
                        <label>D1</label>

                        <input type="number" step="0.01" name="d1" value="{{ old('d1', $inspeksi->d1) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- D2 -->
                    <div class="mb-4">
                        <label>D2</label>

                        <input type="number" step="0.01" name="d2" value="{{ old('d2', $inspeksi->d2) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- D3 -->
                    <div class="mb-4">
                        <label>D3</label>

                        <input type="number" step="0.01" name="d3" value="{{ old('d3', $inspeksi->d3) }}"
                            class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Dimensi -->
                    <div class="mb-4">
                        <label>Dimensi</label>

                        <select name="dimensi" class="w-full border rounded px-3 py-2">

                            <option value="OK" {{ old('dimensi', $inspeksi->dimensi) == 'OK' ? 'selected' : '' }}>
                                OK
                            </option>

                            <option value="NG" {{ old('dimensi', $inspeksi->dimensi) == 'NG' ? 'selected' : '' }}>
                                NG
                            </option>

                        </select>
                    </div>

                    <!-- Visual -->
                    <div class="mb-4">
                        <label>Visual</label>

                        <select name="visual" class="w-full border rounded px-3 py-2">

                            <option value="OK" {{ old('visual', $inspeksi->visual) == 'OK' ? 'selected' : '' }}>
                                OK
                            </option>

                            <option value="NG" {{ old('visual', $inspeksi->visual) == 'NG' ? 'selected' : '' }}>
                                NG
                            </option>

                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label>Keterangan</label>

                        <textarea name="keterangan" class="w-full border rounded px-3 py-2">{{ old('keterangan', $inspeksi->keterangan) }}</textarea>
                    </div>
                    <!-- File/Gambar -->
                    <div class="mb-4">
                        <label>Upload Gambar</label>

                        <input type="file" name="files[]" multiple class="w-full border rounded px-3 py-2">

                        @if ($inspeksi->files)
                            <div class="mt-3 flex flex-wrap gap-3">

                                @foreach ($inspeksi->files as $file)
                                    <img src="{{ asset('storage/' . $file) }}"
                                        class="w-24 h-24 object-cover rounded border">
                                @endforeach

                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end gap-2">

                        <a href="{{ route('incomingbahanbaku.show', $incomingbahanbaku->id) }}"
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
