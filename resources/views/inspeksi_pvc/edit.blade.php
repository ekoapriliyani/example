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

                    <form action="{{ route('inspeksi_pvc.update', $inspeksi_pvc->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksi_pvc->nomor_inspeksi) }}" readonly />
                        </div>
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Inspeksi')" />
                            <x-text-input id="tanggal" name="tanggal" type="date"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('tanggal', $inspeksi_pvc->tanggal) }}" />
                        </div>

                        <div>
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}" data-description="{{ $pro->description }}"
                                        {{ old('pro_id', $inspeksi_pvc->pro_id) == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->pro_id }} - {{ $pro->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" type="text" class="mt-1 block w-full bg-gray-100"
                                :value="old('description', optional($inspeksi_pvc->pro)->description)" readonly />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1"
                                    {{ old('shift', $inspeksi_pvc->shift) == '1' ? 'selected' : '' }}>
                                    Shift 1
                                </option>
                                <option value="2"
                                    {{ old('shift', $inspeksi_pvc->shift) == '2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="3"
                                    {{ old('shift', $inspeksi_pvc->shift) == '3' ? 'selected' : '' }}>Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="d_kawat_inti" :value="__('Diameter Kawat Inti')" />
                            <x-text-input id="d_kawat_inti" name="d_kawat_inti" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('d_kawat_inti', $inspeksi_pvc->d_kawat_inti) }}" />
                        </div>
                        <div>
                            <x-input-label for="d_kawat_pvc" :value="__('Diameter Kawat PVC')" />
                            <x-text-input id="d_kawat_pvc" name="d_kawat_pvc" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('d_kawat_pvc', $inspeksi_pvc->d_kawat_pvc) }}" />
                        </div>

                        <div>
                            <x-input-label for="type_coating" :value="__('Type Coating')" />
                            <select id="type_coating" name="type_coating"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Type Coating --</option>
                                <option value="LG"
                                    {{ old('type_coating', $inspeksi_pvc->type_coating) == 'LG' ? 'selected' : '' }}>LG
                                </option>
                                <option value="HG"
                                    {{ old('type_coating', $inspeksi_pvc->type_coating) == 'HG' ? 'selected' : '' }}>HG
                                </option>
                                <option value="ZN-AL"
                                    {{ old('type_coating', $inspeksi_pvc->type_coating) == 'ZN-AL' ? 'selected' : '' }}>
                                    ZN-AL
                                </option>
                                <option value="ULTRA"
                                    {{ old('type_coating', $inspeksi_pvc->type_coating) == 'ULTRA' ? 'selected' : '' }}>
                                    ULTRA
                                </option>
                                <option value="BLACK"
                                    {{ old('type_coating', $inspeksi_pvc->type_coating) == 'BLACK' ? 'selected' : '' }}>
                                    BLACK
                                </option>
                                <option value="EP"
                                    {{ old('type_coating', $inspeksi_pvc->type_coating) == 'EP' ? 'selected' : '' }}>EP
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type_coating')" />
                        </div>

                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id', $inspeksi_pvc->mesin_id) == $mesin->id ? 'selected' : '' }}>
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
                                        class="block w-full" value="{{ old('total_prod', $inspeksi_pvc->total_prod) }}"
                                        placeholder="0.00" />
                                </div>
                                <div class="w-32">
                                    <select id="satuan" name="satuan"
                                        class="block w-full border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="unit"
                                            {{ old('satuan', $inspeksi_pvc->satuan) == 'unit' ? 'selected' : '' }}>unit
                                        </option>
                                        <option value="pcs"
                                            {{ old('satuan', $inspeksi_pvc->satuan) == 'pcs' ? 'selected' : '' }}>pcs
                                        </option>
                                        <option value="kg"
                                            {{ old('satuan', $inspeksi_pvc->satuan) == 'kg' ? 'selected' : '' }}>kg
                                        </option>
                                        <option value="roll"
                                            {{ old('satuan', $inspeksi_pvc->satuan) == 'roll' ? 'selected' : '' }}>roll
                                        </option>
                                        <option value="lembar"
                                            {{ old('satuan', $inspeksi_pvc->satuan) == 'lembar' ? 'selected' : '' }}>
                                            lembar
                                        </option>
                                        <option value="ton"
                                            {{ old('satuan', $inspeksi_pvc->satuan) == 'ton' ? 'selected' : '' }}>ton
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                            <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('inspeksi_pvc.index') }}"
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

    {{--  --}}
    <script>
        $('#product_pvc_ref_id').select2({
            placeholder: '-- Pilih Product pvc --',
            allowClear: true,
            width: '100%'
        });
    </script>
</x-app-layout>
