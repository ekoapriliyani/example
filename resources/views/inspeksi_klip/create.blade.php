<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Inspeksi Baru') }}
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

                    <form action="{{ route('inspeksi_klip.store') }}" method="POST" class="space-y-6">
                        @csrf
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
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}"
                                        {{ old('pro_id') == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->pro_id }}
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
                            <x-input-label for="product_razor_ref_id" :value="__('Product razor')" />
                            <select id="product_razor_ref_id" name="product_razor_ref_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Product razor --</option>
                                @foreach ($productrazors as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_razor_ref_id') == $product->id ? 'selected' : '' }}>
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
                                <option value="1" {{ old('shift') == '1' ? 'selected' : '' }}>Shift 1
                                </option>
                                <option value="2" {{ old('shift') == '2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="3" {{ old('shift') == '3' ? 'selected' : '' }}>Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="total_prod" :value="__('Total Produksi per Shift')" />
                            <x-text-input id="total_prod" name="total_prod" type="number" step="0.01"
                                class="mt-1 block w-full" value="{{ old('total_prod') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                        </div>

                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id') == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->mesin_id }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                            <a href="{{ route('inspeksi_klip.index') }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
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
            $('#pro_id').select2({
                placeholder: '-- Pilih PRO --',
                allowClear: true,
                width: '100%'
            });

            $('#product_razor_ref_id').select2({
                placeholder: '-- Pilih Product razor --',
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

            @if (old('pro_id'))
                loadProDetail("{{ old('pro_id') }}");
            @endif
        });
    </script>
</x-app-layout>
