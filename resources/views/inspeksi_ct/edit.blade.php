<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Inspeksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Silakan masukkan detail operasional untuk pencatatan inspeksi QC baru.
                        </p>
                    </div>

                    <form action="{{ route('inspeksi_ct.update', $inspeksi_ct->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksi_ct->nomor_inspeksi) }}" readonly />
                        </div>
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Inspeksi')" />
                            <x-text-input id="tanggal" name="tanggal" type="date"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('tanggal', $inspeksi_ct->tanggal) }}" />
                        </div>

                        <div>
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}" data-description="{{ $pro->description }}"
                                        {{ old('pro_id', $inspeksi_ct->pro_id) == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->pro_id }} - {{ $pro->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" type="text" class="mt-1 block w-full bg-gray-100"
                                :value="old('description', optional($inspeksi_ct->pro)->description)" readonly />
                        </div>

                        <div>
                            <x-input-label for="qty" :value="__('QTY')" />
                            <x-text-input id="qty" type="text" class="mt-1 block w-full bg-gray-100"
                                :value="old('qty', optional($inspeksi_ct->pro)->qty)" readonly />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1" {{ old('shift', $inspeksi_ct->shift) == '1' ? 'selected' : '' }}>
                                    Shift 1
                                </option>
                                <option value="2"
                                    {{ old('shift', $inspeksi_ct->shift) == '2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="3"
                                    {{ old('shift', $inspeksi_ct->shift) == '3' ? 'selected' : '' }}>Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id', $inspeksi_ct->mesin_id) == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->mesin_id }} - {{ $mesin->nama_mesin }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                        </div>

                        <div>
                            <x-input-label for="total_prod" :value="__('Total Produksi (diisi diakhir shift)')" class="text-red-600 italic" />
                            <div class="flex items-center space-x-2 mt-1">
                                <div class="relative flex-1">
                                    <x-text-input id="total_prod" name="total_prod" type="number" step="0.01"
                                        class="block w-full" value="{{ old('total_prod', $inspeksi_ct->total_prod) }}"
                                        placeholder="0.00" />
                                </div>
                                <div class="w-32">
                                    <select id="satuan" name="satuan"
                                        class="block w-full border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="unit"
                                            {{ old('satuan', $inspeksi_ct->satuan) == 'unit' ? 'selected' : '' }}>
                                            unit
                                        </option>
                                        <option value="pcs"
                                            {{ old('satuan', $inspeksi_ct->satuan) == 'pcs' ? 'selected' : '' }}>
                                            pcs
                                        </option>
                                        <option value="kg"
                                            {{ old('satuan', $inspeksi_ct->satuan) == 'kg' ? 'selected' : '' }}>kg
                                        </option>
                                        <option value="roll"
                                            {{ old('satuan', $inspeksi_ct->satuan) == 'roll' ? 'selected' : '' }}>
                                            roll
                                        </option>
                                        <option value="lembar"
                                            {{ old('satuan', $inspeksi_ct->satuan) == 'lembar' ? 'selected' : '' }}>
                                            lembar
                                        </option>
                                        <option value="ton"
                                            {{ old('satuan', $inspeksi_ct->satuan) == 'ton' ? 'selected' : '' }}>
                                            ton
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                            <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('inspeksi_ct.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Update Inspeksi') }}
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
            $('#pro_id').select2({
                placeholder: '-- Pilih PRO --',
                allowClear: true,
                width: '100%'
            });

            function updateDescription() {
                let selected = $('#pro_id').find(':selected');
                let desc = selected.data('description') || '';
                $('#description').val(desc);
            }

            updateDescription();

            $('#pro_id').on('change', function() {
                updateDescription();
            });
        });
    </script>

    {{-- mesin --}}
    <script>
        $('#mesin_id').select2({
            placeholder: '-- Pilih Mesin --',
            allowClear: true,
            width: '100%'
        });
    </script>

</x-app-layout>
