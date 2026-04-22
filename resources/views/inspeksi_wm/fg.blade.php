<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Hasil Inspeksi FG') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksi_wm->nomor_inspeksi }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('inspeksi_wm_fg.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_wm_id" value="{{ $inspeksi_wm->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="batch_number" :value="__('Batch Number')" />
                                <x-text-input id="batch_number" name="batch_number" type="number"
                                    class="mt-1 block w-full" required placeholder="Contoh: B-2024-001" />
                                <x-input-error class="mt-2" :messages="$errors->get('batch_number')" />
                            </div>

                            <div>
                                <x-input-label for="qty" :value="__('Quantity (Unit)')" />
                                <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full"
                                    required placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>

                            <div class="md:col-span-2">
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
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-text-input id="weight" name="weight" type="number" class="mt-1 block w-full"
                                    required placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-200 pt-6">
                            <h3 class="font-semibold text-gray-700 mb-4">Detail Inspeksi</h3>
                            <div id="detail-wrapper" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="detail_name_0" :value="__('Name')" />
                                        <select id="detail_name_0" name="detail_name[]"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Pilih Detail --</option>
                                            <option value="OK">OK</option>
                                            <option value="Karat">Karat</option>
                                            <option value="Trimming">Trimming</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="detail_description_0" :value="__('Description')" />
                                        <x-text-input id="detail_description_0" name="detail_description[]"
                                            type="text" class="mt-1 block w-full" placeholder="Deskripsi detail" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" id="add-detail"
                                    class="px-3 py-1 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                                    + Tambah Detail
                                </button>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload File')" />
                                <input id="files" name="files[]" type="file"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple>
                                <x-input-error class="mt-2" :messages="$errors->get('files.*')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('inspeksi_wm.show', $inspeksi_wm->id) }}"
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="detail_name_${index}" class="block text-sm font-medium text-gray-700">Name</label>
                <select id="detail_name_${index}" name="detail_name[]"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Detail --</option>
                    <option value="OK">OK</option>
                    <option value="Karat">Karat</option>
                    <option value="Trimming">Trimming</option>
                </select>
            </div>
            <div>
                <label for="detail_description_${index}" class="block text-sm font-medium text-gray-700">Description</label>
                <input id="detail_description_${index}" name="detail_description[]" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi detail" />
            </div>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', newDetail);
        });
    </script>
</x-app-layout>
