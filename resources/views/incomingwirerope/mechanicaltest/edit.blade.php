<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Mechanical Test Wire Rope') }}
            </h2>
            <p class="text-sm text-gray-500">
                No Koil: <span class="font-mono font-bold text-indigo-600">{{ $inspeksi->no_koil }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">

                    <form
                        action="{{ route('incomingwirerope.mechanical_test.update', [
                            'inspeksi' => $inspeksi->id,
                        ]) }}"
                        method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="no_koil" :value="__('No Koil')" />
                                <x-text-input id="no_koil" type="text" class="mt-1 block w-full bg-gray-50"
                                    :value="$inspeksi->no_koil" readonly disabled />
                            </div>

                            <div>
                                <x-input-label for="mechanical_status" :value="__('Status Mechanical Test')" />
                                <select id="mechanical_status" name="mechanical_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled>-- Pilih Status --</option>
                                    <option value="OK"
                                        {{ old('mechanical_status', $inspeksi->mechanical_status) == 'OK' ? 'selected' : '' }}>
                                        OK</option>
                                    <option value="NG"
                                        {{ old('mechanical_status', $inspeksi->mechanical_status) == 'NG' ? 'selected' : '' }}>
                                        NG</option>
                                    <option value="REJECT"
                                        {{ old('mechanical_status', $inspeksi->mechanical_status) == 'REJECT' ? 'selected' : '' }}>
                                        REJECT</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('mechanical_status')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="tensile_strength_kawat_inti"
                                    :value="__('Tensile Strength Kawat Inti (MPa)')" />
                                <x-text-input id="tensile_strength_kawat_inti" name="tensile_strength_kawat_inti"
                                    type="number" step="0.01" class="mt-1 block w-full"
                                    :value="old('tensile_strength_kawat_inti', $inspeksi->tensile_strength_kawat_inti)" required />
                                <x-input-error class="mt-2"
                                    :messages="$errors->get('tensile_strength_kawat_inti')" />
                            </div>

                            @if ($inspeksi->mechanical_lot_number)
                                <div class="md:col-span-2">
                                    <x-input-label :value="__('Lot Number')" />
                                    <x-text-input type="text" class="mt-1 block w-full bg-gray-50"
                                        :value="$inspeksi->mechanical_lot_number" readonly disabled />
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <div>
                                <x-input-label for="files" :value="__('Upload File / Gambar Baru (Bisa Multi-upload)')" />
                                <input type="file" id="files" name="files[]" accept="image/*,.pdf" multiple
                                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="mt-1 text-xs text-gray-400">
                                    *Biarkan kosong jika tidak ingin mengubah lampiran gambar lama.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('files')" />
                                <x-input-error class="mt-2" :messages="$errors->get('files.*')" />
                            </div>

                            @if ($inspeksi->mechanical_files && count($inspeksi->mechanical_files))
                                <div class="border-t border-gray-200 pt-4">
                                    <span
                                        class="mb-2 block text-xs font-semibold uppercase tracking-wider text-gray-500">Lampiran
                                        File Aktif Saat Ini:</span>
                                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                                        @foreach ($inspeksi->mechanical_files as $file)
                                            @php
                                                $actualFile = is_array($file) ? $file[0] ?? '' : $file;
                                                $ext = !empty($actualFile)
                                                    ? pathinfo((string) $actualFile, PATHINFO_EXTENSION)
                                                    : '';
                                            @endphp

                                            @if (!empty($actualFile))
                                                <div
                                                    class="group relative rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                        <img src="{{ asset('storage/' . $actualFile) }}"
                                                            alt="Old Attachment"
                                                            class="mb-1 h-32 w-full rounded bg-gray-50 object-contain">
                                                        <span
                                                            class="block truncate text-center text-[10px] text-gray-400">{{ basename($actualFile) }}</span>
                                                    @else
                                                        <div
                                                            class="mb-1 flex h-32 w-full flex-col items-center justify-center rounded bg-gray-100 text-indigo-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <span
                                                                class="mt-1 text-xs font-bold uppercase">{{ $ext ?: 'DOC' }}
                                                                File</span>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $actualFile) }}"
                                                            target="_blank"
                                                            class="block truncate text-center text-[10px] font-medium text-indigo-600 hover:underline">
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

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                            <a href="{{ route('incomingwirerope.show', $inspeksi->incoming_wire_rope_id) }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
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
