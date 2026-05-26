<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Inspeksi Kawat Duri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Silakan ubah detail operasional inspeksi QC kawat duri.
                        </p>
                    </div>

                    <form action="{{ route('inspeksi_kawat_duri.update', $inspeksiKawatDuri->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksiKawatDuri->nomor_inspeksi) }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('nomor_inspeksi')" />
                        </div>

                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                value="{{ old('tanggal', $inspeksiKawatDuri->tanggal) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                        </div>

                        <div>
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}"
                                        {{ old('pro_id', $inspeksiKawatDuri->pro_id) == $pro->id ? 'selected' : '' }}>
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
                            <x-input-label for="total_prod" :value="__('Total Produksi per Shift')" />
                            <x-text-input id="total_prod" name="total_prod" type="number" step="0.01"
                                class="mt-1 block w-full"
                                value="{{ old('total_prod', $inspeksiKawatDuri->total_prod) }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1"
                                    {{ old('shift', $inspeksiKawatDuri->shift) == '1' ? 'selected' : '' }}>
                                    Shift 1
                                </option>
                                <option value="2"
                                    {{ old('shift', $inspeksiKawatDuri->shift) == '2' ? 'selected' : '' }}>
                                    Shift 2
                                </option>
                                <option value="3"
                                    {{ old('shift', $inspeksiKawatDuri->shift) == '3' ? 'selected' : '' }}>
                                    Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="type_coating" :value="__('Type Coating')" />
                            <select id="type_coating" name="type_coating"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Type Coating --</option>
                                <option value="LG"
                                    {{ old('type_coating', $inspeksiKawatDuri->type_coating) == 'LG' ? 'selected' : '' }}>
                                    LG</option>
                                <option value="HG"
                                    {{ old('type_coating', $inspeksiKawatDuri->type_coating) == 'HG' ? 'selected' : '' }}>
                                    HG</option>
                                <option value="ZN-AL"
                                    {{ old('type_coating', $inspeksiKawatDuri->type_coating) == 'ZN-AL' ? 'selected' : '' }}>
                                    ZN-AL</option>
                                <option value="ULTRA"
                                    {{ old('type_coating', $inspeksiKawatDuri->type_coating) == 'ULTRA' ? 'selected' : '' }}>
                                    ULTRA</option>
                                <option value="BLACK"
                                    {{ old('type_coating', $inspeksiKawatDuri->type_coating) == 'BLACK' ? 'selected' : '' }}>
                                    BLACK</option>
                                <option value="EP"
                                    {{ old('type_coating', $inspeksiKawatDuri->type_coating) == 'EP' ? 'selected' : '' }}>
                                    EP</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type_coating')" />
                        </div>

                        <div>
                            <x-input-label for="warna" :value="__('Warna (kosongin jika tidak ada)')" />
                            <select id="warna" name="warna"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Warna --</option>
                                <option value="Abu-Abu"
                                    {{ old('warna', $inspeksiKawatDuri->warna) == 'Abu-Abu' ? 'selected' : '' }}>
                                    Abu-Abu</option>
                                <option value="Hijau"
                                    {{ old('warna', $inspeksiKawatDuri->warna) == 'Hijau' ? 'selected' : '' }}>
                                    Hijau</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('warna')" />
                        </div>

                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id', $inspeksiKawatDuri->mesin_id) == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->mesin_id }} - {{ $mesin->nama_mesin }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('inspeksi_kawat_duri.index') }}"
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
