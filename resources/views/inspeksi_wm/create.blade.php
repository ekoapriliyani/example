<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Inspeksi Baru') }}
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

                    <form action="{{ route('inspeksi_wm.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100" value="{{ $nextNomor }}" readonly />
                        </div>

                        <div>
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}" data-description="{{ $pro->description }}">
                                        {{ $pro->pro_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text"
                                class="mt-1 block w-full bg-gray-100" readonly />
                        </div>
                        <div>
                            <x-input-label for="product_wm_ref_id" :value="__('Product WM')" />
                            <select id="product_wm_ref_id" name="product_wm_ref_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Product WM --</option>
                                @foreach ($productWms as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_wm_ref_id', $inspeksi_wm->product_wm_ref_id ?? '') == $product->id ? 'selected' : '' }}>

                                        {{ $product->product_wm_id }} - {{ $product->description }}

                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('product_wm_ref_id')" />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="shift1" {{ old('shift') == 'shift1' ? 'selected' : '' }}>Shift 1
                                </option>
                                <option value="shift2" {{ old('shift') == 'shift2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="shift3" {{ old('shift') == 'shift3' ? 'selected' : '' }}>Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="grade" :value="__('Grade')" />
                            <select id="grade" name="grade"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Grade --</option>
                                <option value="SNI" {{ old('grade') == 'SNI' ? 'selected' : '' }}>SNI</option>
                                <option value="NON SNI" {{ old('grade') == 'NON SNI' ? 'selected' : '' }}>NON SNI
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('grade')" />
                        </div>

                        <div>
                            <x-input-label for="type_coating" :value="__('Type Coating')" />
                            <select id="type_coating" name="type_coating"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Type Coating --</option>
                                <option value="LG" {{ old('type_coating') == 'LG' ? 'selected' : '' }}>LG</option>
                                <option value="HG" {{ old('type_coating') == 'HG' ? 'selected' : '' }}>HG</option>
                                <option value="ZN-AL" {{ old('type_coating') == 'ZN-AL' ? 'selected' : '' }}>ZN-AL
                                </option>
                                <option value="ULTRA" {{ old('type_coating') == 'ULTRA' ? 'selected' : '' }}>ULTRA
                                </option>
                                <option value="BLACK" {{ old('type_coating') == 'BLACK' ? 'selected' : '' }}>BLACK
                                </option>
                                <option value="EP" {{ old('type_coating') == 'EP' ? 'selected' : '' }}>EP</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type_coating')" />
                        </div>
                        <div>
                            <x-input-label for="shear_strength" :value="__('Shear Strength')" />
                            <div class="relative mt-1">
                                <x-text-input id="shear_strength" name="shear_strength" type="number" step="1"
                                    class="block w-full pr-12" :value="old('shear_strength')" required placeholder="0.00" />
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                    mpa
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                        </div>

                        <div>
                            <x-input-label for="mesin_id" :value="__('Mesin')" />
                            <select id="mesin_id" name="mesin_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Mesin --</option>
                                @foreach ($mesins as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_id') == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->nama_mesin }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('inspeksi_wm.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
            $('#mesin_id').select2({
                placeholder: '-- Pilih Mesin --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#pro_id').select2({
                placeholder: '-- Pilih PRO --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    {{-- Auto isi description (tetap jalan) --}}
    <script>
        $(document).ready(function() {
            $('#pro_id').select2({
                placeholder: '-- Pilih PRO --',
                allowClear: true,
                width: '100%'
            });

            $('#pro_id').on('change', function() {
                let selected = $(this).find(':selected');
                let desc = selected.data('description');

                $('#description').val(desc ?? '');
            });
        });
    </script>
    {{-- pilih product wm --}}
    <script>
        $('#product_wm_ref_id').select2({
            placeholder: '-- Pilih Product WM --',
            allowClear: true,
            width: '100%'
        });
    </script>
</x-app-layout>
