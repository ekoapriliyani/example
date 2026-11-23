<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Edit Inspeksi Wire Rope
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

            <div class="rounded bg-white p-6 shadow">

                <form
                    action="{{ route('incomingwirerope.inspeksi.update', [
                        'incomingwirerope' => $incomingwirerope->id,
                        'inspeksi' => $inspeksi->id,
                    ]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label>No Koil</label>
                        <input type="text" name="no_koil" value="{{ old('no_koil', $inspeksi->no_koil) }}"
                            class="w-full rounded border px-3 py-2" required>
                        @error('no_koil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2 border-t pt-4">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Wire Rope</h3>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <div>
                            <label>D1 Wire Rope</label>
                            <input type="number" step="0.01" name="d1_wire_rope"
                                value="{{ old('d1_wire_rope', $inspeksi->d1_wire_rope) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                        <div>
                            <label>D2 Wire Rope</label>
                            <input type="number" step="0.01" name="d2_wire_rope"
                                value="{{ old('d2_wire_rope', $inspeksi->d2_wire_rope) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                        <div>
                            <label>D3 Wire Rope</label>
                            <input type="number" step="0.01" name="d3_wire_rope"
                                value="{{ old('d3_wire_rope', $inspeksi->d3_wire_rope) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                    </div>

                    <div class="mb-2 border-t pt-4">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Kawat Inti</h3>
                    </div>
                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <div>
                            <label>D1 Kawat Inti</label>
                            <input type="number" step="0.01" name="d1_kawat_inti"
                                value="{{ old('d1_kawat_inti', $inspeksi->d1_kawat_inti) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                        <div>
                            <label>D2 Kawat Inti</label>
                            <input type="number" step="0.01" name="d2_kawat_inti"
                                value="{{ old('d2_kawat_inti', $inspeksi->d2_kawat_inti) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                        <div>
                            <label>D3 Kawat Inti</label>
                            <input type="number" step="0.01" name="d3_kawat_inti"
                                value="{{ old('d3_kawat_inti', $inspeksi->d3_kawat_inti) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                        <div>
                            <label>Jml Kawat Inti</label>
                            <input type="number" name="jml_kawat_inti"
                                value="{{ old('jml_kawat_inti', $inspeksi->jml_kawat_inti) }}"
                                class="w-full rounded border px-3 py-2">
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label>Dimensi</label>
                            <select name="dimensi" class="w-full rounded border px-3 py-2">
                                <option value="OK"
                                    {{ old('dimensi', $inspeksi->dimensi) == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="NG"
                                    {{ old('dimensi', $inspeksi->dimensi) == 'NG' ? 'selected' : '' }}>NG</option>
                                <option value="REJECT"
                                    {{ old('dimensi', $inspeksi->dimensi) == 'REJECT' ? 'selected' : '' }}>REJECT
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label>Visual</label>
                            <select name="visual" class="w-full rounded border px-3 py-2">
                                <option value="OK"
                                    {{ old('visual', $inspeksi->visual) == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="NG"
                                    {{ old('visual', $inspeksi->visual) == 'NG' ? 'selected' : '' }}>NG</option>
                                <option value="REJECT"
                                    {{ old('visual', $inspeksi->visual) == 'REJECT' ? 'selected' : '' }}>REJECT
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
                                @foreach (['KARAT', 'WHITE RUST', 'CRACK/FLAKING', 'RUAS BAMBU', 'BINTIK HITAM', 'DIAMETER OUT', 'TENSILE OUT', 'COATING OUT', 'PUNTIR OUT', 'LILIT OUT'] as $desc)
                                    <option value="{{ $desc }}"
                                        {{ old('description1', $inspeksi->description1) == $desc ? 'selected' : '' }}>
                                        {{ $desc }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description2">Description 2</label>
                            <select id="description2" name="description2" class="w-full rounded border px-3 py-2">
                                <option value=""
                                    {{ old('description2', $inspeksi->description2) == '' ? 'selected' : '' }}>
                                    -- Pilih Deskripsi --
                                </option>
                                @foreach (['KARAT', 'WHITE RUST', 'CRACK/FLAKING', 'RUAS BAMBU', 'BINTIK HITAM', 'DIAMETER OUT', 'TENSILE OUT', 'COATING OUT', 'PUNTIR OUT', 'LILIT OUT'] as $desc)
                                    <option value="{{ $desc }}"
                                        {{ old('description2', $inspeksi->description2) == $desc ? 'selected' : '' }}>
                                        {{ $desc }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label>Upload Gambar</label>

                        <input type="file" name="files[]" multiple class="w-full rounded border px-3 py-2">

                        @if ($inspeksi->files)
                            <div class="mt-3 flex flex-wrap gap-3">
                                @foreach ($inspeksi->files as $file)
                                    @php
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    @endphp
                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <img src="{{ asset('storage/' . $file) }}"
                                            class="h-24 w-24 rounded border object-cover">
                                    @else
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                            class="flex h-24 w-24 items-center justify-center rounded border bg-gray-50 text-xs font-semibold text-indigo-600">
                                            {{ strtoupper($ext) ?: 'FILE' }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @error('files.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('incomingwirerope.show', $incomingwirerope->id) }}"
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
