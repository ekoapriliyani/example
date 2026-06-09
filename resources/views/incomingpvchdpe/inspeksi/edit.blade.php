<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Inspeksi Incoming PVC / HDPE') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref ID Induk: <span
                    class="font-mono font-bold text-indigo-600">#{{ $inspeksi->incoming_pvc_hdpe_id }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">

                    <div
                        class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500 italic text-xs">No Inspeksi Induk:</span>
                            <span
                                class="font-semibold text-gray-800">{{ $inspeksi->incomingPvcHdpe->nomor_inspeksi ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 italic text-xs">Supplier:</span>
                            <span
                                class="font-semibold text-gray-800">{{ $inspeksi->incomingPvcHdpe->supplier->nama ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 italic text-xs">No PO:</span>
                            <span
                                class="font-semibold text-gray-800">{{ $inspeksi->incomingPvcHdpe->no_po ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 italic text-xs">No SJ:</span>
                            <span
                                class="font-semibold text-gray-800">{{ $inspeksi->incomingPvcHdpe->no_sj ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <form action="{{ route('incomingpvchdpe.inspeksi.update', $inspeksi->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="warna" :value="__('Warna PVC / HDPE')" />
                                <select name="warna" id="warna"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="" disabled>-- Pilih Warna --</option>
                                    <option value="Abu-Abu"
                                        {{ old('warna', $inspeksi->warna) == 'Abu-Abu' ? 'selected' : '' }}>Abu-Abu
                                    </option>
                                    <option value="Hijau"
                                        {{ old('warna', $inspeksi->warna) == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                                    <option value="Putih"
                                        {{ old('warna', $inspeksi->warna) == 'Putih' ? 'selected' : '' }}>Putih</option>
                                    <option value="Hitam"
                                        {{ old('warna', $inspeksi->warna) == 'Hitam' ? 'selected' : '' }}>Hitam
                                    </option>
                                    <option value="Biru"
                                        {{ old('warna', $inspeksi->warna) == 'Biru' ? 'selected' : '' }}>Biru</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('warna')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status Kelayakan')" />
                                <select name="status" id="status"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="OK"
                                        {{ old('status', $inspeksi->status) == 'OK' ? 'selected' : '' }}>OK (Passed)
                                    </option>
                                    <option value="NG"
                                        {{ old('status', $inspeksi->status) == 'NG' ? 'selected' : '' }}>NG (Not Good)
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan / Temuan QC')" />
                            <textarea name="keterangan" id="keterangan" rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm placeholder-gray-400"
                                placeholder="Tuliskan catatan inspeksi visual produk, ukuran ketebalan, atau penyimpangan jika status produk NG...">{{ old('keterangan', $inspeksi->keterangan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>

                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg space-y-4">
                            <div>
                                <x-input-label for="files" :value="__('Upload File/Gambar Baru (Mendukung Multi-upload)')" />
                                <input type="file" id="files" name="files[]" multiple accept="image/*,.pdf"
                                    class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                                <p class="mt-1 text-xs text-gray-400">*Biarkan kosong jika tetap ingin mempertahankan
                                    berkas lampiran lama.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('files')" />
                            </div>

                            @if ($inspeksi->files && count($inspeksi->files))
                                <div class="border-t border-gray-200 pt-4">
                                    <span
                                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Lampiran
                                        File Aktif Saat Ini:</span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                        @foreach ($inspeksi->files as $file)
                                            @php
                                                // Mengamankan potensi double casting / nested array data json
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
                                                                class="text-xs font-bold mt-1 uppercase">{{ $ext ?: 'PDF' }}
                                                                File</span>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $actualFile) }}" target="_blank"
                                                            class="block text-[10px] text-center text-indigo-600 font-medium hover:underline truncate">
                                                            Buka Dokumen
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
                            <a href="{{ route('incomingpvchdpe.show', $inspeksi->incoming_pvc_hdpe_id) }}"
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
