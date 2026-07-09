<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Inspeksi QC') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <form action="{{ route('outgoing.inspeksi.store', $outgoing->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="mb-2 block text-base font-semibold text-gray-800">
                            Item Pengecekan Outgoing
                        </label>

                        <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead
                                    class="bg-gray-50 text-left font-medium text-gray-700 uppercase tracking-wider text-xs">
                                    <tr>
                                        <th class="px-4 py-3 text-center w-12">No</th>
                                        <th class="px-6 py-3">Item Pengecekan</th>
                                        <th class="px-6 py-3 text-center w-64">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-gray-900">
                                    @php
                                        $checklistItems = [
                                            ['key' => 'A', 'label' => 'Label', 'field' => 'label'],
                                            ['key' => 'B', 'label' => 'Tidak Berkarat', 'field' => 'karat'],
                                            ['key' => 'C', 'label' => 'Tidak Penyok', 'field' => 'penyok'],
                                            ['key' => 'D', 'label' => 'Tidak Kotor/Hitam', 'field' => 'kotor'],
                                            ['key' => 'E', 'label' => 'Tidak Pecah Galvanis', 'field' => 'galvanized'],
                                            ['key' => 'F', 'label' => 'Tidak Lepas Lasan', 'field' => 'lasan'],
                                            ['key' => 'G', 'label' => 'Mesh Tidak Rusak', 'field' => 'mesh'],
                                            ['key' => 'H', 'label' => 'PVC Tidak Sobek', 'field' => 'pvc'],
                                            ['key' => 'I', 'label' => 'Packing Tidak Rusak', 'field' => 'packing'],
                                            ['key' => 'J', 'label' => 'Quantity', 'field' => 'qty'],
                                        ];
                                    @endphp

                                    @foreach ($checklistItems as $item)
                                        @php
                                            $oldValue = old($item['field'], '-');

                                            // Menentukan class warna baris saat pertama kali dimuat (jika ada error/old value)
                                            $rowColor = 'hover:bg-gray-50';
                                            if ($oldValue == 'OK') {
                                                $rowColor = 'bg-green-50';
                                            }
                                            if ($oldValue == 'NG') {
                                                $rowColor = 'bg-red-50';
                                            }
                                        @endphp

                                        <tr class="row-checklist transition-colors duration-150 {{ $rowColor }}">
                                            <td class="px-4 py-3 text-center font-medium text-gray-500">
                                                {{ $item['key'] }}</td>
                                            <td class="px-6 py-3 font-medium text-gray-700">{{ $item['label'] }}</td>
                                            <td class="px-6 py-3">
                                                <div class="flex items-center justify-center space-x-4">
                                                    <label
                                                        class="inline-flex items-center cursor-pointer p-1 rounded hover:bg-gray-100">
                                                        <input type="radio" name="{{ $item['field'] }}" value="OK"
                                                            class="h-4 w-4 border-gray-300 text-green-600 focus:ring-green-500"
                                                            {{ $oldValue == 'OK' ? 'checked' : '' }}
                                                            onchange="updateRowColor(this)">
                                                        <span
                                                            class="ml-1.5 text-xs font-semibold text-green-700">OK</span>
                                                    </label>

                                                    <label
                                                        class="inline-flex items-center cursor-pointer p-1 rounded hover:bg-gray-100">
                                                        <input type="radio" name="{{ $item['field'] }}" value="NG"
                                                            class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-500"
                                                            {{ $oldValue == 'NG' ? 'checked' : '' }}
                                                            onchange="updateRowColor(this)">
                                                        <span
                                                            class="ml-1.5 text-xs font-semibold text-red-700">NG</span>
                                                    </label>

                                                    <label
                                                        class="inline-flex items-center cursor-pointer p-1 rounded hover:bg-gray-100">
                                                        <input type="radio" name="{{ $item['field'] }}" value="-"
                                                            class="h-4 w-4 border-gray-300 text-gray-500 focus:ring-gray-400"
                                                            {{ $oldValue == '-' ? 'checked' : '' }}
                                                            onchange="updateRowColor(this)">
                                                        <span class="ml-1.5 text-xs font-semibold text-gray-500">N/A
                                                            (-)</span>
                                                    </label>
                                                </div>
                                                @error($item['field'])
                                                    <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}
                                                    </p>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- upload file --}}
                        <div class="mt-4">
                            <x-input-label for="files" :value="__('Upload File Foto Dokumentasi')" />
                            <input id="files" name="files[]" type="file"
                                class="mt-1 block w-full border border-gray-300 p-2 rounded-md shadow-sm text-sm"
                                multiple>
                            @error('files')
                                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('outgoing.show', $outgoing->id) }}"
                            class="px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                            Simpan Inspeksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateRowColor(radio) {
            const row = radio.closest('.row-checklist');

            // Reset semua warna latar belakang terlebih dahulu
            row.classList.remove('bg-green-50', 'bg-red-50', 'hover:bg-gray-50');

            // Berikan warna sesuai value radio yang dipilih
            if (radio.value === 'OK') {
                row.classList.add('bg-green-50');
            } else if (radio.value === 'NG') {
                row.classList.add('bg-red-50');
            } else {
                row.classList.add('hover:bg-gray-50');
            }
        }
    </script>
</x-app-layout>
