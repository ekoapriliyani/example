<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Mechanical Test') }}
            </h2>
            <p class="text-sm text-gray-500">
                Koil Ref: <span class="font-mono font-bold text-indigo-600">{{ $mechanicalTest->nomor_koil }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">

                    <form action="{{ route('incomingbahanbaku.mechanical_test.update', $mechanicalTest->id) }}"
                        method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nomor_koil" :value="__('Nomor Koil')" />
                                <x-text-input id="nomor_koil" name="nomor_koil" type="text"
                                    class="mt-1 block w-full bg-gray-50" :value="old('nomor_koil', $mechanicalTest->nomor_koil)" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('nomor_koil')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status Mechanical Test')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="" disabled>-- Pilih Status --</option>
                                    <option value="OK"
                                        {{ old('status', $mechanicalTest->status) == 'OK' ? 'selected' : '' }}>OK
                                        (Passed)</option>
                                    <option value="NG"
                                        {{ old('status', $mechanicalTest->status) == 'NG' ? 'selected' : '' }}>NG (Not
                                        Good)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="hasil_tensile" :value="__('Hasil Tensile (Mpa)')" />
                                <x-text-input id="hasil_tensile" name="hasil_tensile" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('hasil_tensile', $mechanicalTest->hasil_tensile)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hasil_tensile')" />
                            </div>

                            <div>
                                <x-input-label for="hasil_coatingweight" :value="__('Hasil Coating Weight (g/m²)')" />
                                <x-text-input id="hasil_coatingweight" name="hasil_coatingweight" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('hasil_coatingweight', $mechanicalTest->hasil_coatingweight)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hasil_coatingweight')" />
                            </div>

                            <div>
                                <x-input-label for="hasil_lilit" :value="__('Hasil Lilit')" />
                                <select id="hasil_lilit" name="hasil_lilit"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="" disabled>-- Pilih Hasil Lilit --</option>
                                    <option value="OK"
                                        {{ old('hasil_lilit', $mechanicalTest->hasil_lilit) == 'OK' ? 'selected' : '' }}>
                                        OK</option>
                                    <option value="CRACK"
                                        {{ old('hasil_lilit', $mechanicalTest->hasil_lilit) == 'CRACK' ? 'selected' : '' }}>
                                        CRACK</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('hasil_lilit')" />
                            </div>

                            <div>
                                <x-input-label for="hasil_puntir" :value="__('Hasil Puntir (Kali)')" />
                                <x-text-input id="hasil_puntir" name="hasil_puntir" type="number"
                                    class="mt-1 block w-full" :value="old('hasil_puntir', $mechanicalTest->hasil_puntir)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('hasil_puntir')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="description1">
                                {{ __('Description 1') }} <span class="text-red-600 text-xs font-semibold">(Isi jika
                                    NG)</span>
                            </x-input-label>
                            <select id="description1" name="description1"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value=""
                                    {{ old('description1', $mechanicalTest->description1) == '' ? 'selected' : '' }}>--
                                    PILIH DESKRIPSI --</option>
                                <option value="KARAT"
                                    {{ old('description1', $mechanicalTest->description1) == 'KARAT' ? 'selected' : '' }}>
                                    KARAT</option>
                                <option value="WHITE RUST"
                                    {{ old('description1', $mechanicalTest->description1) == 'WHITE RUST' ? 'selected' : '' }}>
                                    WHITE RUST</option>
                                <option value="CRACK/FLAKING"
                                    {{ old('description1', $mechanicalTest->description1) == 'CRACK/FLAKING' ? 'selected' : '' }}>
                                    CRACK/FLAKING</option>
                                <option value="RUAS BAMBU"
                                    {{ old('description1', $mechanicalTest->description1) == 'RUAS BAMBU' ? 'selected' : '' }}>
                                    RUAS BAMBU</option>
                                <option value="BINTIK HITAM"
                                    {{ old('description1', $mechanicalTest->description1) == 'BINTIK HITAM' ? 'selected' : '' }}>
                                    BINTIK HITAM</option>
                                <option value="DIAMETER OUT"
                                    {{ old('description1', $mechanicalTest->description1) == 'DIAMETER OUT' ? 'selected' : '' }}>
                                    DIAMETER OUT</option>
                                <option value="TENSILE OUT"
                                    {{ old('description1', $mechanicalTest->description1) == 'TENSILE OUT' ? 'selected' : '' }}>
                                    TENSILE OUT</option>
                                <option value="COATING OUT"
                                    {{ old('description1', $mechanicalTest->description1) == 'COATING OUT' ? 'selected' : '' }}>
                                    COATING OUT</option>
                                <option value="PUNTIR OUT"
                                    {{ old('description1', $mechanicalTest->description1) == 'PUNTIR OUT' ? 'selected' : '' }}>
                                    PUNTIR OUT</option>
                                <option value="LILIT OUT"
                                    {{ old('description1', $mechanicalTest->description1) == 'LILIT OUT' ? 'selected' : '' }}>
                                    LILIT OUT</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('description1')" />
                        </div>

                        <div>
                            <x-input-label for="description2">
                                {{ __('Description 2') }} <span class="text-red-600 text-xs font-semibold">(Isi jika
                                    NG)</span>
                            </x-input-label>
                            <select id="description2" name="description2"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value=""
                                    {{ old('description2', $mechanicalTest->description2) == '' ? 'selected' : '' }}>--
                                    PILIH DESKRIPSI --</option>
                                <option value="KARAT"
                                    {{ old('description2', $mechanicalTest->description2) == 'KARAT' ? 'selected' : '' }}>
                                    KARAT</option>
                                <option value="WHITE RUST"
                                    {{ old('description2', $mechanicalTest->description2) == 'WHITE RUST' ? 'selected' : '' }}>
                                    WHITE RUST</option>
                                <option value="CRACK/FLAKING"
                                    {{ old('description2', $mechanicalTest->description2) == 'CRACK/FLAKING' ? 'selected' : '' }}>
                                    CRACK/FLAKING</option>
                                <option value="RUAS BAMBU"
                                    {{ old('description2', $mechanicalTest->description2) == 'RUAS BAMBU' ? 'selected' : '' }}>
                                    RUAS BAMBU</option>
                                <option value="BINTIK HITAM"
                                    {{ old('description2', $mechanicalTest->description2) == 'BINTIK HITAM' ? 'selected' : '' }}>
                                    BINTIK HITAM</option>
                                <option value="DIAMETER OUT"
                                    {{ old('description2', $mechanicalTest->description2) == 'DIAMETER OUT' ? 'selected' : '' }}>
                                    DIAMETER OUT</option>
                                <option value="TENSILE OUT"
                                    {{ old('description2', $mechanicalTest->description2) == 'TENSILE OUT' ? 'selected' : '' }}>
                                    TENSILE OUT</option>
                                <option value="COATING OUT"
                                    {{ old('description2', $mechanicalTest->description2) == 'COATING OUT' ? 'selected' : '' }}>
                                    COATING OUT</option>
                                <option value="PUNTIR OUT"
                                    {{ old('description2', $mechanicalTest->description2) == 'PUNTIR OUT' ? 'selected' : '' }}>
                                    PUNTIR OUT</option>
                                <option value="LILIT OUT"
                                    {{ old('description2', $mechanicalTest->description2) == 'LILIT OUT' ? 'selected' : '' }}>
                                    LILIT OUT</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('description2')" />
                        </div>

                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg space-y-4">
                            <div>
                                <x-input-label for="files" :value="__('Upload File/Gambar Baru (Bisa Multi-upload)')" />
                                <input type="file" id="files" name="files[]" multiple
                                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="mt-1 text-xs text-gray-400">*Biarkan kosong jika tidak ingin mengubah dokumen
                                    lampiran gambar lama.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('files')" />
                            </div>

                            @if ($mechanicalTest->files && count($mechanicalTest->files))
                                <div class="border-t border-gray-200 pt-4">
                                    <span
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Lampiran
                                        File Aktif Saat Ini:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                        @foreach ($mechanicalTest->files as $file)
                                            @php
                                                // Proteksi penanganan jenis data array vs string pathinfo
                                                $actualFile = is_array($file) ? $file[0] ?? '' : $file;
                                                $ext = !empty($actualFile)
                                                    ? pathinfo((string) $actualFile, PATHINFO_EXTENSION)
                                                    : '';
                                            @endphp

                                            @if (!empty($actualFile))
                                                <div
                                                    class="relative group p-2 border border-gray-200 bg-white rounded-lg shadow-sm">
                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                        <img src="{{ asset('storage/' . $actualFile) }}"
                                                            alt="Old Attachment"
                                                            class="w-full h-32 object-contain rounded mb-1 bg-gray-50">
                                                        <span
                                                            class="block text-[10px] text-gray-400 truncate text-center">{{ basename($actualFile) }}</span>
                                                    @else
                                                        <div
                                                            class="w-full h-32 flex flex-col items-center justify-center bg-gray-100 rounded text-indigo-600 mb-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <span
                                                                class="text-xs font-bold mt-1 uppercase">{{ $ext ?: 'DOC' }}
                                                                File</span>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $actualFile) }}"
                                                            target="_blank"
                                                            class="block text-[10px] text-center text-indigo-600 font-medium hover:underline truncate">
                                                            View Document
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('incomingbahanbaku.show', $mechanicalTest->incoming_bahan_baku_id) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
