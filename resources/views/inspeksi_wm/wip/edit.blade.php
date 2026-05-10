<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_wm->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('inspeksi_wm_wip.update', $wip->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_wm_id" value="{{ old('inspeksi_wm_id', $wip->inspeksi_wm_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="no_material" :value="__('Nomor Material')" />
                                <x-text-input id="no_material" name="no_material" type="number"
                                    class="mt-1 block w-full"
                                    :value="old('no_material', $wip->no_material)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>

                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full"
                                    :value="old('nama_operator', $wip->nama_operator)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="d_kawat_act" :value="__('Diameter Kawat (Actual)')" />
                                <x-text-input id="d_kawat_act" name="d_kawat_act" type="number" step="0.01"
                                    class="mt-1 block w-full"
                                    :value="old('d_kawat_act', $wip->d_kawat_act)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_kawat_act')" />
                            </div>

                            <div>
                                <x-input-label for="selisih_diagonal" :value="__('Selisih Diagonal (Actual)')" />
                                <x-text-input id="selisih_diagonal" name="selisih_diagonal" type="number" step="1"
                                    class="mt-1 block w-full"
                                    :value="old('selisih_diagonal', $wip->selisih_diagonal)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('selisih_diagonal')" />
                            </div>

                            <div>
                                <x-input-label for="p_product_act" :value="__('Panjang Produk (Actual)')" />
                                <x-text-input id="p_product_act" name="p_product_act" type="number" step="1"
                                    class="mt-1 block w-full"
                                    :value="old('p_product_act', $wip->p_product_act)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('p_product_act')" />
                            </div>

                            <div>
                                <x-input-label for="l_product_act" :value="__('Lebar Produk (Actual)')" />
                                <x-text-input id="l_product_act" name="l_product_act" type="number" step="1"
                                    class="mt-1 block w-full"
                                    :value="old('l_product_act', $wip->l_product_act)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('l_product_act')" />
                            </div>

                            <div>
                                <x-input-label for="p_mesh_act" :value="__('Panjang Mesh (Actual)')" />
                                <x-text-input id="p_mesh_act" name="p_mesh_act" type="number" step="1"
                                    class="mt-1 block w-full"
                                    :value="old('p_mesh_act', $wip->p_mesh_act)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('p_mesh_act')" />
                            </div>

                            <div>
                                <x-input-label for="l_mesh_act" :value="__('Lebar Mesh (Actual)')" />
                                <x-text-input id="l_mesh_act" name="l_mesh_act" type="number" step="1"
                                    class="mt-1 block w-full"
                                    :value="old('l_mesh_act', $wip->l_mesh_act)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('l_mesh_act')" />
                            </div>

                            <div>
                                <x-input-label for="torsi_strength" :value="__('Torsi Strength')" />
                                <select id="torsi_strength" name="torsi_strength"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="OK" {{ old('torsi_strength', $wip->torsi_strength) == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('torsi_strength', $wip->torsi_strength) == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('torsi_strength')" />
                            </div>

                            <div>
                                <x-input-label for="status_dimensi" :value="__('Dimensi')" />
                                <select id="status_dimensi" name="status_dimensi"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="OK" {{ old('status_dimensi', $wip->status_dimensi) == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('status_dimensi', $wip->status_dimensi) == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status_dimensi')" />
                            </div>

                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="OK" {{ old('visual', $wip->visual) == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG" {{ old('visual', $wip->visual) == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>

                            <div>
                                <x-input-label for="shear_strength" :value="__('Shear Strength')" />
                                <x-text-input id="shear_strength" name="shear_strength" type="number" step="0.01"
                                    class="mt-1 block w-full"
                                    :value="old('shear_strength', $wip->shear_strength)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                            </div>

                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01"
                                    class="mt-1 block w-full"
                                    :value="old('weight', $wip->weight)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-200 pt-6">
                            <h3 class="font-semibold text-gray-700 mb-4">Detail Inspeksi</h3>

                            <div id="detail-wrapper" class="space-y-4">
                                @php
                                    $details = old('detail_description')
                                        ? collect(old('detail_description'))->map(function ($item, $key) {
                                            return [
                                                'description' => old('detail_description')[$key] ?? '',
                                                'description2' => old('detail_description2')[$key] ?? '',
                                                'qty' => old('detail_qty')[$key] ?? '',
                                            ];
                                        })
                                        : $wip->details;
                                @endphp

                                @forelse ($details as $index => $detail)
                                    @php
                                        $desc = is_array($detail) ? $detail['description'] : $detail->description;
                                        $desc2 = is_array($detail) ? $detail['description2'] : $detail->description2;
                                        $qty = is_array($detail) ? $detail['qty'] : $detail->qty;
                                    @endphp

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 detail-row">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                @include('partials.option-detail-inspeksi', ['selected' => $desc])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                @include('partials.option-detail-inspeksi', ['selected' => $desc2])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full"
                                                value="{{ $qty }}" />
                                        </div>
                                    </div>
                                @empty
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 detail-row">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                @include('partials.option-detail-inspeksi', ['selected' => ''])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                @include('partials.option-detail-inspeksi', ['selected' => ''])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full" />
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="mt-4">
                                <button type="button" id="add-detail"
                                    class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                    + Tambah Detail
                                </button>
                            </div>

                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload Gambar / File Baru')" />
                                <input id="files" name="files[]" type="file"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">

                                @error('files')
                                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                @enderror

                                @error('files.*')
                                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('inspeksi_wm.show', $inspeksi_wm->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
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
        const optionsDetail = `
            <option value="">-- Pilih Detail --</option>
            <option value="OK">OK</option>
            <option value="LAS (LEPAS/TIDAK NGELAS)">LAS (LEPAS/TIDAK NGELAS)</option>
            <option value="DIAMETER OUT">DIAMETER OUT</option>
            <option value="TEBAL OUT">TEBAL OUT</option>
            <option value="PANJANG OUT">PANJANG OUT</option>
            <option value="LEBAR OUT">LEBAR OUT</option>
            <option value="TINGGI OUT">TINGGI OUT</option>
            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
            <option value="OVERHANG OUT">OVERHANG OUT</option>
            <option value="KARAT">KARAT</option>
            <option value="WHITE RUST">WHITE RUST</option>
            <option value="TRIMING">TRIMING</option>
            <option value="CRACK">CRACK</option>
            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
            <option value="PVC/HDPE PECAH/SOBEK">PVC/HDPE PECAH/SOBEK</option>
            <option value="PVC/HDPE MIRING">PVC/HDPE MIRING</option>
            <option value="PVC/HDPE KASAR">PVC/HDPE KASAR</option>
            <option value="JARAK DURI/BLADE">JARAK DURI/BLADE</option>
            <option value="BLADE PECAH/SOBEK">BLADE PECAH/SOBEK</option>
            <option value="PISAU POUNCH TUMPUL">PISAU POUNCH TUMPUL</option>
            <option value="BENDING TIDAK PRESS">BENDING TIDAK PRESS</option>
            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
        `;

        document.getElementById('add-detail').addEventListener('click', function () {
            let wrapper = document.getElementById('detail-wrapper');

            let newDetail = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 detail-row">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <select name="detail_description[]"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            ${optionsDetail}
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description 2</label>
                        <select name="detail_description2[]"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            ${optionsDetail}
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">QTY</label>
                        <input name="detail_qty[]" type="number"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="QTY" />
                    </div>
                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-app-layout>
