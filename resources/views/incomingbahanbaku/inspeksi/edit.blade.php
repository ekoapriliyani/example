<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Edit Inspeksi Incoming
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

            <div class="rounded bg-white p-6 shadow">

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
                            class="w-full rounded border px-3 py-2" required>
                    </div>

                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <!-- D1 -->
                        <div class="mb-4">
                            <label>D1</label>

                            <input type="number" step="0.01" name="d1" value="{{ old('d1', $inspeksi->d1) }}"
                                class="w-full rounded border px-3 py-2" required>
                        </div>

                        <!-- D2 -->
                        <div class="mb-4">
                            <label>D2</label>

                            <input type="number" step="0.01" name="d2" value="{{ old('d2', $inspeksi->d2) }}"
                                class="w-full rounded border px-3 py-2" required>
                        </div>

                        <!-- D3 -->
                        <div class="mb-4">
                            <label>D3</label>

                            <input type="number" step="0.01" name="d3" value="{{ old('d3', $inspeksi->d3) }}"
                                class="w-full rounded border px-3 py-2" required>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <!-- Dimensi -->
                        <div class="mb-4">
                            <label>Dimensi</label>

                            <select name="dimensi" class="w-full rounded border px-3 py-2">

                                <option value="OK"
                                    {{ old('dimensi', $inspeksi->dimensi) == 'OK' ? 'selected' : '' }}>
                                    OK
                                </option>

                                <option value="NG"
                                    {{ old('dimensi', $inspeksi->dimensi) == 'NG' ? 'selected' : '' }}>
                                    NG
                                </option>

                            </select>
                        </div>

                        <!-- Visual -->
                        <div class="mb-4">
                            <label>Visual</label>

                            <select name="visual" class="w-full rounded border px-3 py-2">

                                <option value="OK" {{ old('visual', $inspeksi->visual) == 'OK' ? 'selected' : '' }}>
                                    OK
                                </option>

                                <option value="NG" {{ old('visual', $inspeksi->visual) == 'NG' ? 'selected' : '' }}>
                                    NG
                                </option>

                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description1">Description 1</label>
                            <select id="description1" name="description1" class="w-full rounded border px-3 py-2">
                                <option value=""
                                    {{ old('description1', $inspeksi->description1) == '' ? 'selected' : '' }}>
                                    -- Pilih Deskripsi --
                                </option>
                                <option value="KARAT"
                                    {{ old('description1', $inspeksi->description1) == 'KARAT' ? 'selected' : '' }}>
                                    KARAT
                                </option>
                                <option value="WHITE RUST"
                                    {{ old('description1', $inspeksi->description1) == 'WHITE RUST' ? 'selected' : '' }}>
                                    WHITE RUST</option>
                                <option value="CRACK/FLAKING"
                                    {{ old('description1', $inspeksi->description1) == 'CRACK/FLAKING' ? 'selected' : '' }}>
                                    CRACK/FLAKING</option>
                                <option value="RUAS BAMBU"
                                    {{ old('description1', $inspeksi->description1) == 'RUAS BAMBU' ? 'selected' : '' }}>
                                    RUAS BAMBU</option>
                                <option value="BINTIK HITAM"
                                    {{ old('description1', $inspeksi->description1) == 'BINTIK HITAM' ? 'selected' : '' }}>
                                    BINTIK HITAM</option>
                                <option value="DIAMETER OUT"
                                    {{ old('description1', $inspeksi->description1) == 'DIAMETER OUT' ? 'selected' : '' }}>
                                    DIAMETER OUT</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description2">Description 2</label>
                            <select id="description2" name="description2" class="w-full rounded border px-3 py-2">
                                <option value=""
                                    {{ old('description2', $inspeksi->description2) == '' ? 'selected' : '' }}>
                                    -- Pilih Deskripsi --
                                </option>
                                <option value="KARAT"
                                    {{ old('description2', $inspeksi->description2) == 'KARAT' ? 'selected' : '' }}>
                                    KARAT
                                </option>
                                <option value="WHITE RUST"
                                    {{ old('description2', $inspeksi->description2) == 'WHITE RUST' ? 'selected' : '' }}>
                                    WHITE RUST</option>
                                <option value="CRACK/FLAKING"
                                    {{ old('description2', $inspeksi->description2) == 'CRACK/FLAKING' ? 'selected' : '' }}>
                                    CRACK/FLAKING</option>
                                <option value="RUAS BAMBU"
                                    {{ old('description2', $inspeksi->description2) == 'RUAS BAMBU' ? 'selected' : '' }}>
                                    RUAS BAMBU</option>
                                <option value="BINTIK HITAM"
                                    {{ old('description2', $inspeksi->description2) == 'BINTIK HITAM' ? 'selected' : '' }}>
                                    BINTIK HITAM</option>
                                <option value="DIAMETER OUT"
                                    {{ old('description2', $inspeksi->description2) == 'DIAMETER OUT' ? 'selected' : '' }}>
                                    DIAMETER OUT</option>
                            </select>
                        </div>
                    </div>



                    <!-- Keterangan -->
                    {{-- <div class="mb-4">
                        <label>Keterangan</label>

                        <textarea name="keterangan" class="w-full border rounded px-3 py-2">{{ old('keterangan', $inspeksi->keterangan) }}</textarea>
                    </div> --}}

                    <!-- File/Gambar -->
                    <div class="mb-4">
                        <label>Upload Gambar</label>

                        <input type="file" name="files[]" multiple class="w-full rounded border px-3 py-2">

                        @if ($inspeksi->files)
                            <div class="mt-3 flex flex-wrap gap-3">

                                @foreach ($inspeksi->files as $file)
                                    <img src="{{ asset('storage/' . $file) }}"
                                        class="h-24 w-24 rounded border object-cover">
                                @endforeach

                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end gap-2">

                        <a href="{{ route('incomingbahanbaku.show', $incomingbahanbaku->id) }}"
                            class="rounded bg-gray-300 px-4 py-2">
                            Batal
                        </a>

                        <button class="rounded bg-blue-600 px-4 py-2 text-white">
                            Update
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
