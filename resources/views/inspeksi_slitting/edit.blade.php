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

                    <form action="{{ route('inspeksi_slitting.update', $inspeksi_slitting->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksi_slitting->nomor_inspeksi) }}" readonly />
                        </div>
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Inspeksi')" />
                            <x-text-input id="tanggal" name="tanggal" type="date"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('tanggal', $inspeksi_slitting->tanggal) }}" />
                        </div>

                        <div>
                            <x-input-label for="pro_id" :value="__('PRO Number')" />
                            <select id="pro_id" name="pro_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih PRO --</option>
                                @foreach ($pros as $pro)
                                    <option value="{{ $pro->id }}" data-description="{{ $pro->description }}"
                                        {{ old('pro_id', $inspeksi_slitting->pro_id) == $pro->id ? 'selected' : '' }}>
                                        {{ $pro->pro_id }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('pro_id')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" type="text" class="mt-1 block w-full bg-gray-100"
                                :value="old('description', optional($inspeksi_slitting->pro)->description)" readonly />
                        </div>

                        <div>
                            <x-input-label for="qty_ordered" :value="__('Qty Ordered')" />
                            <x-text-input id="qty_ordered" type="text" class="mt-1 block w-full bg-gray-100"
                                :value="old('qty_ordered', optional($inspeksi_slitting->pro)->qty)" readonly />
                        </div>

                        <div>
                            <x-input-label for="ukuran" :value="__('Ukuran')" />
                            <select id="ukuran" name="ukuran"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih ukuran --</option>
                                <option value="21"
                                    {{ old('ukuran', $inspeksi_slitting->ukuran) == 21 ? 'selected' : '' }}>21
                                </option>
                                <option value="25"
                                    {{ old('ukuran', $inspeksi_slitting->ukuran) == 25 ? 'selected' : '' }}>25
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('ukuran')" />
                        </div>



                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="1"
                                    {{ old('shift', $inspeksi_slitting->shift) == '1' ? 'selected' : '' }}>Shift 1
                                </option>
                                <option value="2"
                                    {{ old('shift', $inspeksi_slitting->shift) == '2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="3"
                                    {{ old('shift', $inspeksi_slitting->shift) == '3' ? 'selected' : '' }}>Shift 3
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
                                        {{ old('mesin_id', $inspeksi_slitting->mesin_id) == $mesin->id ? 'selected' : '' }}>
                                        {{ $mesin->mesin_id }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('mesin_id')" />
                        </div>
                        <div class="">
                            <x-input-label for="total_prod" :value="__('Total Produksi (kg)')" />
                            <x-text-input id="total_prod" name="total_prod" type="number" step="0.01"
                                class="mt-1 block w-full"
                                value="{{ old('total_prod', $inspeksi_slitting->total_prod) }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('total_prod')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-4">
                            <a href="{{ route('inspeksi_slitting.index') }}"
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
        $('#product_slitting_ref_id').select2({
            placeholder: '-- Pilih Product slitting --',
            allowClear: true,
            width: '100%'
        });
    </script>
</x-app-layout>
