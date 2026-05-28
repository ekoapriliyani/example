<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Inspeksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Silakan masukkan detail operasional untuk pencatatan inspeksi QC baru.
                        </p>
                    </div>

                    <form action="{{ route('inspeksi_klip.update', $inspeksi_klip->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksi_klip->nomor_inspeksi) }}" readonly />
                        </div>
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Inspeksi')" />
                            <x-text-input id="tanggal" name="tanggal" type="date"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('tanggal', $inspeksi_klip->tanggal) }}" />
                        </div>

                        <div>
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}" data-description="{{ $pro->description }}"
                                        {{ old('pro_id', $inspeksi_klip->pro_id) == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->pro_id }} - {{ $pro->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" type="text" class="mt-1 block w-full bg-gray-100"
                                :value="old('description', optional($inspeksi_klip->pro)->description)" readonly />
                        </div>

                        <div>
                            <x-input-label for="product_razor_ref_id" :value="__('Product Razor')" />
                            <select id="product_razor_ref_id" name="product_razor_ref_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Product Razor --</option>
                                @foreach ($productrazors as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_razor_ref_id', $inspeksi_klip->product_razor_ref_id ?? '') == $product->id ? 'selected' : '' }}>

                                        {{ $product->product_razor_id }} - {{ $product->description }}

                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('product_razor_ref_id')" />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1"
                                    {{ old('shift', $inspeksi_klip->shift) == '1' ? 'selected' : '' }}>Shift 1
                                </option>
                                <option value="2"
                                    {{ old('shift', $inspeksi_klip->shift) == '2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="3"
                                    {{ old('shift', $inspeksi_klip->shift) == '3' ? 'selected' : '' }}>Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id', $inspeksi_klip->mesin_id) == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->mesin_id }}
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
                                        class="block w-full"
                                        value="{{ old('total_prod', $inspeksi_klip->total_prod) }}"
                                        placeholder="0.00" />
                                </div>
                                <div class="w-32">
                                    <select id="satuan" name="satuan"
                                        class="block w-full border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="unit"
                                            {{ old('satuan', $inspeksi_klip->satuan) == 'unit' ? 'selected' : '' }}>
                                            unit
                                        </option>
                                        <option value="pcs"
                                            {{ old('satuan', $inspeksi_klip->satuan) == 'pcs' ? 'selected' : '' }}>
                                            pcs
                                        </option>
                                        <option value="kg"
                                            {{ old('satuan', $inspeksi_klip->satuan) == 'kg' ? 'selected' : '' }}>kg
                                        </option>
                                        <option value="roll"
                                            {{ old('satuan', $inspeksi_klip->satuan) == 'roll' ? 'selected' : '' }}>
                                            roll
                                        </option>
                                        <option value="lembar"
                                            {{ old('satuan', $inspeksi_klip->satuan) == 'lembar' ? 'selected' : '' }}>
                                            lembar
                                        </option>
                                        <option value="ton"
                                            {{ old('satuan', $inspeksi_klip->satuan) == 'ton' ? 'selected' : '' }}>
                                            ton
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                            <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                            <a href="{{ route('inspeksi_klip.index') }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
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
        $('#product_klip_ref_id').select2({
            placeholder: '-- Pilih Product klip --',
            allowClear: true,
            width: '100%'
        });
    </script>
</x-app-layout>
