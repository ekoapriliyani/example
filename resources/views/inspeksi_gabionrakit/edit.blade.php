<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Inspeksi Gabionrakit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Silakan ubah detail operasional inspeksi QC Gabionrakit.
                        </p>
                    </div>

                    <form action="{{ route('inspeksi_gabionrakit.update', $inspeksiGabionrakit->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksiGabionrakit->nomor_inspeksi) }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('nomor_inspeksi')" />
                        </div>

                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                value="{{ old('tanggal', $inspeksiGabionrakit->tanggal) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                        </div>

                        <div>
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}"
                                        {{ old('pro_id', $inspeksiGabionrakit->pro_id) == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->pro_id }} - {{ $pro->description }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                        </div>

                        <div>
                            <x-input-label for="pro_description" :value="__('Description')" />
                            <x-text-input id="pro_description" type="text" class="mt-1 block w-full bg-gray-100"
                                value="{{ old('pro_description') }}" readonly />
                        </div>

                        <div>
                            <x-input-label for="pro_qty" :value="__('Qty Ordered')" />
                            <x-text-input id="pro_qty" type="text" class="mt-1 block w-full bg-gray-100"
                                value="{{ old('pro_qty') }}" readonly />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1"
                                    {{ old('shift', $inspeksiGabionrakit->shift) == '1' ? 'selected' : '' }}>
                                    Shift 1
                                </option>
                                <option value="2"
                                    {{ old('shift', $inspeksiGabionrakit->shift) == '2' ? 'selected' : '' }}>
                                    Shift 2
                                </option>
                                <option value="3"
                                    {{ old('shift', $inspeksiGabionrakit->shift) == '3' ? 'selected' : '' }}>
                                    Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>
                        <div class="">
                            <x-input-label for="diameter" :value="__('Diameter')" />
                            <x-text-input id="diameter" name="diameter" type="number" step="0.01"
                                class="mt-1 block w-full" value="{{ old('diameter', $inspeksiGabionrakit->diameter) }}"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('diameter')" />
                        </div>
                        <div class="">
                            <x-input-label for="ukuran" :value="__('Ukuran')" />
                            <x-text-input id="ukuran" name="ukuran" type="text" class="mt-1 block w-full"
                                value="{{ old('ukuran', $inspeksiGabionrakit->ukuran) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('ukuran')" />
                        </div>
                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id', $inspeksiGabionrakit->mesin_id) == $mesin->id ? 'selected' : '' }}>
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
                                        class="block w-full"
                                        value="{{ old('total_prod', $inspeksiGabionrakit->total_prod) }}"
                                        placeholder="0.00" />
                                </div>
                                <div class="w-32">
                                    <select id="satuan" name="satuan"
                                        class="block w-full border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="unit"
                                            {{ old('satuan', $inspeksiGabionrakit->satuan) == 'unit' ? 'selected' : '' }}>
                                            unit
                                        </option>
                                        <option value="pcs"
                                            {{ old('satuan', $inspeksiGabionrakit->satuan) == 'pcs' ? 'selected' : '' }}>
                                            pcs
                                        </option>
                                        <option value="kg"
                                            {{ old('satuan', $inspeksiGabionrakit->satuan) == 'kg' ? 'selected' : '' }}>
                                            kg
                                        </option>
                                        <option value="roll"
                                            {{ old('satuan', $inspeksiGabionrakit->satuan) == 'roll' ? 'selected' : '' }}>
                                            roll
                                        </option>
                                        <option value="lembar"
                                            {{ old('satuan', $inspeksiGabionrakit->satuan) == 'lembar' ? 'selected' : '' }}>
                                            lembar
                                        </option>
                                        <option value="ton"
                                            {{ old('satuan', $inspeksiGabionrakit->satuan) == 'ton' ? 'selected' : '' }}>
                                            ton
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                            <x-input-error class="mt-2" :messages="$errors->get('satuan')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('inspeksi_gabionrakit.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
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

            $('#mesin_id').select2({
                placeholder: '-- Pilih Mesin --',
                allowClear: true,
                width: '100%'
            });

            async function loadProDetail(proId) {
                const descriptionInput = document.getElementById('pro_description');
                const qtyInput = document.getElementById('pro_qty');

                descriptionInput.value = '';
                qtyInput.value = '';

                if (!proId) return;

                try {
                    const response = await fetch(`/pro/${proId}/detail`);

                    if (!response.ok) {
                        throw new Error('HTTP error ' + response.status);
                    }

                    const data = await response.json();

                    descriptionInput.value = data.description ?? '';
                    qtyInput.value = data.qty ?? '';
                } catch (error) {
                    console.error('Gagal mengambil detail PRO:', error);
                }
            }

            $('#pro_id').on('change', function() {
                loadProDetail($(this).val());
            });

            const selectedProId = $('#pro_id').val();

            if (selectedProId) {
                loadProDetail(selectedProId);
            }
        });
    </script>
</x-app-layout>
