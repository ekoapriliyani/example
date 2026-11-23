<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Inspeksi Incoming Wire Rope') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Incoming Wire Rope
                        </p>
                    </div>

                    <form action="{{ route('incomingwirerope.store') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mt-2">
                            <x-input-label for="jenis" :value="__('Jenis')" />
                            <div class="mt-1 flex items-center gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis" value="reguler" required
                                        {{ old('jenis', 'reguler') == 'reguler' ? 'checked' : '' }}
                                        class="border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Reguler</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis" value="non_reguler"
                                        {{ old('jenis') == 'non_reguler' ? 'checked' : '' }}
                                        class="border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Non Reguler (Jika Stock Opname/dll)</span>
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis')" />
                        </div>

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100" value="{{ $nextNomor }}" readonly />
                        </div>

                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                value="{{ old('tanggal', now()->format('Y-m-d')) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                        </div>

                        <div>
                            <x-input-label for="supplier_id" :value="__('Pilih Supplier')" />
                            <select id="supplier_id" name="supplier_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('supplier_id')" />
                        </div>

                        <div>
                            <x-input-label for="no_rcr" :value="__('No RCR')" />
                            <select id="no_rcr" name="no_rcr"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih No RCR --</option>
                                @foreach ($receivingData as $row)
                                    <option value="{{ $row['trno'] }}"
                                        data-order-no="{{ $row['OrderNo'] }}"
                                        data-description="{{ $row['description'] }}"
                                        data-total-koil="{{ $row['TotalKoil'] }}"
                                        {{ old('no_rcr') == $row['trno'] ? 'selected' : '' }}>
                                        {{ $row['trno'] }} - {{ $row['OrderNo'] }} - {{ $row['description'] }} -
                                        {{ $row['TotalKoil'] }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('no_rcr')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Deskripsi...">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="no_po" :value="__('No PO')" />
                            <x-text-input id="no_po" name="no_po" type="text" class="mt-1 block w-full"
                                :value="old('no_po')" />
                            <x-input-error class="mt-2" :messages="$errors->get('no_po')" />
                        </div>

                        <div>
                            <x-input-label for="no_sj" :value="__('No SJ')" />
                            <x-text-input id="no_sj" name="no_sj" type="text" class="mt-1 block w-full"
                                :value="old('no_sj')" />
                            <x-input-error class="mt-2" :messages="$errors->get('no_sj')" />
                        </div>

                        <div>
                            <x-input-label for="jml_koil" :value="__('Jml Koil')" />
                            <x-text-input id="jml_koil" name="jml_koil" type="number" class="mt-1 block w-full"
                                :value="old('jml_koil')" />
                            <x-input-error class="mt-2" :messages="$errors->get('jml_koil')" />
                        </div>

                        <div>
                            <x-input-label for="d_kawat" :value="__('D Kawat')" />
                            <select id="d_kawat" name="d_kawat" class="block w-full rounded border px-3 py-2">
                                <option value="">-- Pilih Diameter --</option>
                                @foreach (['1.6', '1.8', '2', '2.5', '2.7', '3', '3.2', '3.4', '3.8', '4', '5', '5.6', '8'] as $d)
                                    <option value="{{ $d }}" {{ old('d_kawat') == $d ? 'selected' : '' }}>
                                        {{ $d }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('d_kawat')" />
                        </div>

                        <div>
                            <x-input-label for="tol" :value="__('Toleransi')" />
                            <x-text-input id="tol" name="tol" type="number" step="0.01" class="mt-1 block w-full"
                                :value="old('tol')" />
                            <x-input-error class="mt-2" :messages="$errors->get('tol')" />
                        </div>

                        <div>
                            <x-input-label for="jenis_kawat" :value="__('Jenis Kawat')" />
                            <select id="jenis_kawat" name="jenis_kawat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Jenis Kawat --</option>
                                @foreach (['LG', 'HG', 'ULTRA', 'BLACK WIRE', 'BEZILUM', 'EP'] as $jk)
                                    <option value="{{ $jk }}" {{ old('jenis_kawat') == $jk ? 'selected' : '' }}>
                                        {{ $jk }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_kawat')" />
                        </div>

                        <div>
                            <x-input-label for="certificate" :value="__('Certificate')" />
                            <x-text-input id="certificate" name="certificate" type="text" class="mt-1 block w-full"
                                :value="old('certificate')" />
                            <x-input-error class="mt-2" :messages="$errors->get('certificate')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="files" :value="__('Upload File')" />
                            <input id="files" name="files[]" type="file" accept="image/*,.pdf"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple>
                            @error('files')
                                <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                            @error('files.*')
                                <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                            <a href="{{ route('incomingwirerope.index') }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Inspeksi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#supplier_id').select2({
                placeholder: '-- Pilih Supplier --',
                allowClear: true,
                width: '100%'
            });

            $('#no_rcr').select2({
                placeholder: '-- Pilih No RCR --',
                allowClear: true,
                width: '100%'
            });

            $('#no_rcr').on('change', function() {
                var selected = $(this).find(':selected');

                $('#no_po').val(selected.data('order-no') || '');
                $('#description').val(selected.data('description') || '');
                $('#jml_koil').val(selected.data('total-koil') || '');
            });
        });
    </script>
</x-app-layout>
