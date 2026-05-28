<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Input Hasil Inspeksi FG') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksiFencing->nomor_inspeksi }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_fencing_fg.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_fencing_id" value="{{ $inspeksiFencing->id }}">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-1">
                            <div class="">
                                <x-input-label :value="__('Type Coating')" class="mb-2" />
                                <div class="flex items-center space-x-6 mt-2">
                                    <label for="type_hotdip" class="inline-flex items-center cursor-pointer">
                                        <input type="radio" id="type_hotdip" name="type" value="HOTDIP"
                                            {{ old('type') == 'HOTDIP' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">HOTDIP</span>
                                    </label>
                                    <label for="type_powder" class="inline-flex items-center cursor-pointer">
                                        <input type="radio" id="type_powder" name="type" value="POWDER COATING"
                                            {{ old('type') == 'POWDER COATING' ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">POWDER COATING</span>
                                    </label>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK">OK</option>
                                    <option value="NG">NG</option>
                                    <option value="REJECT">REJECT</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                            <div>
                                <x-input-label for="qty" :value="__('Quantity (Unit)')" />
                                <x-text-input id="qty" name="qty" type="number" step="0.01"
                                    class="mt-1 block w-full" required placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>
                            <div>
                                <x-input-label for="coating_thickness" :value="__('Coating Thickness')" />
                                <x-text-input id="coating_thickness" name="coating_thickness" type="number"
                                    step="0.01" class="mt-1 block w-full" required placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('coating_thickness')" />
                            </div>
                            <div class="">
                                <x-input-label for="daya_rekat" :value="__('Daya Rekat')" />
                                <select id="daya_rekat" name="daya_rekat"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK">OK</option>
                                    <option value="NG">NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('daya_rekat')" />
                            </div>
                            <div class="">
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK">OK</option>
                                    <option value="NG">NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>
                            <div class="">
                                <x-input-label for="packing" :value="__('packing')" />
                                <select id="packing" name="packing"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK">OK</option>
                                    <option value="NG">NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('packing')" />
                            </div>
                            <div class="">
                                <x-input-label for="label" :value="__('label')" />
                                <select id="label" name="label"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK">OK</option>
                                    <option value="NG">NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('label')" />
                            </div>
                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01"
                                    class="mt-1 block w-full" required placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>
                        </div>


                        <div class="border-t border-gray-200 pt-6 md:col-span-2">
                            <h3 class="mb-4 font-semibold text-gray-700">Detail Inspeksi</h3>
                            <div id="detail-wrapper" class="space-y-4">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div>
                                        <x-input-label for="detail_description_0" :value="__('Description')" />
                                        <select id="detail_description_0" name="detail_description[]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                                            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="DROSS/KASAR/KOTORAN">DROSS/KASAR/KOTORAN</option>
                                            <option value="JARUMAN">JARUMAN</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                                            <option value="LASAN LEPAS">LASAN LEPAS</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="OVERHANG OUT">OVERHANG OUT</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                                            <option value="SCRATCH">SCRATCH</option>
                                            <option value="TEBAL HOTDIP/POWDER COATING">TEBAL HOTDIP/POWDER COATING
                                            </option>
                                            <option value="TINGGI OUT">TINGGI OUT</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description2_0" :value="__('Description 2')" />
                                        <select id="detail_description2_0" name="detail_description2[]"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS
                                            </option>
                                            <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                                            <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                                            <option value="DIAMETER OUT">DIAMETER OUT</option>
                                            <option value="DROSS/KASAR/KOTORAN">DROSS/KASAR/KOTORAN</option>
                                            <option value="JARUMAN">JARUMAN</option>
                                            <option value="KARAT">KARAT</option>
                                            <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                                            <option value="LASAN LEPAS">LASAN LEPAS</option>
                                            <option value="LEBAR OUT">LEBAR OUT</option>
                                            <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS
                                            </option>
                                            <option value="OVERHANG OUT">OVERHANG OUT</option>
                                            <option value="PANJANG OUT">PANJANG OUT</option>
                                            <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                                            <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                                            <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                                            <option value="SCRATCH">SCRATCH</option>
                                            <option value="TEBAL HOTDIP/POWDER COATING">TEBAL HOTDIP/POWDER COATING
                                            </option>
                                            <option value="TINGGI OUT">TINGGI OUT</option>
                                            <option value="WHITE RUST">WHITE RUST</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_qty_0" :value="__('QTY')" />
                                        <x-text-input id="detail_qty_0" name="detail_qty[]" type="number"
                                            class="mt-1 block w-full" placeholder="QTY" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="add-detail"
                                    class="rounded-md bg-indigo-600 px-3 py-1 text-sm text-white hover:bg-indigo-700">
                                    + Tambah Detail
                                </button>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload File')" />
                                <input id="files" name="files[]" type="file"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple>
                                {{-- <x-input-error class="mt-2" :messages="$errors->get('files.*')" /> --}}
                                @error('files')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror

                                @error('files.*')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('inspeksi_fencing.show', $inspeksiFencing->id) }}"
                                class="text-sm text-gray-600 hover:underline">{{ __('Batal') }}</a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                                {{ __('Simpan Data FG') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-detail').addEventListener('click', function() {
            let wrapper = document.getElementById('detail-wrapper');
            let index = wrapper.children.length;
            let newDetail = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="detail_description_${index}" class="block text-sm font-medium text-gray-700">Description</label>
                <select id="detail_description_${index}" name="detail_description[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
                    <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                    <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                    <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="DROSS/KASAR/KOTORAN">DROSS/KASAR/KOTORAN</option>
                    <option value="JARUMAN">JARUMAN</option>
                    <option value="KARAT">KARAT</option>
                    <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                    <option value="LASAN LEPAS">LASAN LEPAS</option>
                    <option value="LEBAR OUT">LEBAR OUT</option>
                    <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                    <option value="OVERHANG OUT">OVERHANG OUT</option>
                    <option value="PANJANG OUT">PANJANG OUT</option>
                    <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                    <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                    <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                    <option value="SCRATCH">SCRATCH</option>
                    <option value="TEBAL HOTDIP/POWDER COATING">TEBAL HOTDIP/POWDER COATING</option>
                    <option value="TINGGI OUT">TINGGI OUT</option>
                    <option value="WHITE RUST">WHITE RUST</option>
                </select>
            </div>
            <div>
                <label for="detail_description2_${index}" class="block text-sm font-medium text-gray-700">Description 2</label>
                <select id="detail_description2_${index}" name="detail_description2[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
                    <option value="CRACK/PEEL OFF/MENGELUPAS">CRACK/PEEL OFF/MENGELUPAS</option>
                    <option value="CW/LW PENDEK">CW/LW PENDEK</option>
                    <option value="DIAGONAL OUT">DIAGONAL OUT</option>
                    <option value="DIAMETER OUT">DIAMETER OUT</option>
                    <option value="DROSS/KASAR/KOTORAN">DROSS/KASAR/KOTORAN</option>
                    <option value="JARUMAN">JARUMAN</option>
                    <option value="KARAT">KARAT</option>
                    <option value="KLIP TIDAK RAPAT">KLIP TIDAK RAPAT</option>
                    <option value="LASAN LEPAS">LASAN LEPAS</option>
                    <option value="LEBAR OUT">LEBAR OUT</option>
                    <option value="MESH OUT / TIDAK SIMETRIS">MESH OUT / TIDAK SIMETRIS</option>
                    <option value="OVERHANG OUT">OVERHANG OUT</option>
                    <option value="PANJANG OUT">PANJANG OUT</option>
                    <option value="PATAH/PUTUS">PATAH/PUTUS</option>
                    <option value="PENYOK/RUSAK">PENYOK/RUSAK</option>
                    <option value="SALAH TEKUK BENDING">SALAH TEKUK BENDING</option>
                    <option value="SCRATCH">SCRATCH</option>
                    <option value="TEBAL HOTDIP/POWDER COATING">TEBAL HOTDIP/POWDER COATING</option>
                    <option value="TINGGI OUT">TINGGI OUT</option>
                    <option value="WHITE RUST">WHITE RUST</option>
                </select>
            </div>
            <div>
                <label for="detail_qty_${index}" class="block text-sm font-medium text-gray-700">QTY</label>
                <input id="detail_qty_${index}" name="detail_qty[]" type="number"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="QTY" />
            </div>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-app-layout>
