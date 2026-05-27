<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_fencing->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_fencing_wip.update', $wip->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_fencing_id"
                            value="{{ old('inspeksi_fencing_id', $wip->inspeksi_fencing_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-2 gap-6 md:grid-cols-3">
                            <div>
                                <x-input-label for="no_material" :value="__('No. Material')" />
                                <x-text-input id="no_material" name="no_material" type="text"
                                    class="mt-1 block w-full" :value="old('no_material', $wip->no_material)" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>
                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator', $wip->nama_operator)" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                            <div>
                                <x-input-label for="d_kawat_act" :value="__('D Kawat Actual')" />
                                <x-text-input id="d_kawat_act" name="d_kawat_act" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_kawat_act', $wip->d_kawat_act)" />
                                <x-input-error class="mt-2" :messages="$errors->get('d_kawat_act')" />
                            </div>
                            <div>
                                <x-input-label for="p_product_act" :value="__('Panjang Product Actual')" />
                                <x-text-input id="p_product_act" name="p_product_act" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('p_product_act', $wip->p_product_act)" />
                                <x-input-error class="mt-2" :messages="$errors->get('p_product_act')" />
                            </div>
                            <div>
                                <x-input-label for="l_product_act" :value="__('Lebar Product Actual')" />
                                <x-text-input id="l_product_act" name="l_product_act" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('l_product_act', $wip->l_product_act)" />
                                <x-input-error class="mt-2" :messages="$errors->get('l_product_act')" />
                            </div>
                            <div>
                                <x-input-label for="t_product_act" :value="__('Tinggi Product Aktual')" />
                                <x-text-input id="t_product_act" name="t_product_act" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('t_product_act', $wip->t_product_act)" />
                                <x-input-error class="mt-2" :messages="$errors->get('t_product_act')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 md:grid-cols-3">
                            <div>
                                <x-input-label for="mesh1" :value="__('Mesh 1')" />
                                <x-text-input id="mesh1" name="mesh1" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh1', $wip->mesh1)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh1')" />
                            </div>
                            <div>
                                <x-input-label for="mesh2" :value="__('Mesh 2')" />
                                <x-text-input id="mesh2" name="mesh2" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh2', $wip->mesh2)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh2')" />
                            </div>
                            <div>
                                <x-input-label for="mesh3" :value="__('Mesh 3')" />
                                <x-text-input id="mesh3" name="mesh3" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh3', $wip->mesh3)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh3')" />
                            </div>
                            <div>
                                <x-input-label for="mesh4" :value="__('Mesh 4')" />
                                <x-text-input id="mesh4" name="mesh4" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh4', $wip->mesh4)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh4')" />
                            </div>
                            <div>
                                <x-input-label for="mesh5" :value="__('Mesh 5')" />
                                <x-text-input id="mesh5" name="mesh5" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh5', $wip->mesh5)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh5')" />
                            </div>
                            <div>
                                <x-input-label for="mesh6" :value="__('Mesh 6')" />
                                <x-text-input id="mesh6" name="mesh6" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh6', $wip->mesh6)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh6')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                            <div>
                                <x-input-label for="diagonal" :value="__('Diagonal')" />
                                <x-text-input id="diagonal" name="diagonal" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('diagonal', $wip->diagonal)" />
                                <x-input-error class="mt-2" :messages="$errors->get('diagonal')" />
                            </div>
                            <div>
                                <x-input-label for="shear_strength" :value="__('Shear Strength')" />
                                <x-text-input id="shear_strength" name="shear_strength" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('shear_strength', $wip->shear_strength)" />
                                <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                            </div>
                            <div>
                                <x-input-label for="overhang" :value="__('Overhang')" />
                                <x-text-input id="overhang" name="overhang" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('overhang', $wip->overhang)" />
                                <x-input-error class="mt-2" :messages="$errors->get('overhang')" />
                            </div>
                            <div>
                                <x-input-label for="matchingcrosswire" :value="__('Matching Crosswire')" />
                                <select id="matchingcrosswire" name="matchingcrosswire"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="OK"
                                        {{ old('matchingcrosswire', $wip->matchingcrosswire) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG"
                                        {{ old('matchingcrosswire', $wip->matchingcrosswire) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('matchingcrosswire')" />
                            </div>
                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="OK" {{ old('visual', $wip->visual) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG" {{ old('visual', $wip->visual) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    {{-- <option value="">-- Pilih status --</option> --}}
                                    <option value="OK" {{ old('status', $wip->status) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG"
                                        {{ old('status', $wip->status) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="mb-4 font-semibold text-gray-700">Files</h3>
                            {{-- File Lama --}}
                            @if ($wip->files)
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    @foreach ($wip->files as $file)
                                        @php
                                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                                        @endphp
                                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $file) }}" alt="FG Image"
                                                    class="mb-3 h-48 w-full rounded border object-contain" />
                                            @else
                                                <div
                                                    class="mb-3 flex h-48 items-center justify-center rounded border bg-white text-gray-400">
                                                    {{ strtoupper($ext) }} FILE
                                                </div>
                                            @endif
                                            <div class="flex items-center justify-between">
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                    class="text-sm font-medium text-indigo-600 hover:underline">
                                                    {{ basename($file) }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="rounded-md border border-dashed border-gray-300 px-4 py-6 text-center text-sm text-gray-400">
                                    Tidak ada file upload.
                                </div>
                            @endif

                            {{-- Upload Baru --}}
                            <div class="mt-6">
                                <x-input-label for="files" :value="__('Upload File Baru')" />
                                <input id="files" name="files[]" type="file" multiple
                                    class="mt-1 block w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">
                                    Bisa upload multiple file (jpg, png, pdf, dll).
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('files')" />
                            </div>
                        </div>

                        {{-- detail --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="mb-4 font-semibold text-gray-700">Detail Inspeksi</h3>

                            <div id="detail-wrapper" class="space-y-4">
                                @forelse ($wip->details as $detail)
                                    <div class="detail-row grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_fencing.wip.options-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_fencing.wip.options-detail', [
                                                    'selected' => $detail->description2,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full"
                                                value="{{ old('detail_qty.' . $loop->index, $detail->qty) }}"
                                                placeholder="QTY" />
                                        </div>
                                    </div>
                                @empty
                                    <div class="detail-row grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_fencing.wip.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_fencing.wip.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full" placeholder="QTY" />
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <button type="button" id="add-detail"
                                class="mt-4 rounded-md bg-indigo-600 px-3 py-2 text-sm text-white hover:bg-indigo-700">
                                + Tambah Detail
                            </button>
                        </div>


                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('inspeksi_fencing.show', $inspeksi_fencing->id) }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Update Data WIP') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const optionsDetail = `@include('inspeksi_fencing.wip.options-detail', ['selected' => null])`;

        document.getElementById('add-detail').addEventListener('click', function() {
            const wrapper = document.getElementById('detail-wrapper');

            const html = `
            <div class="detail-row grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <select name="detail_description[]"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${optionsDetail}
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description 2</label>
                    <select name="detail_description2[]"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${optionsDetail}
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">QTY</label>
                    <input name="detail_qty[]" type="number"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="QTY">
                </div>
            </div>
        `;

            wrapper.insertAdjacentHTML('beforeend', html);
        });
    </script>
</x-app-layout>
