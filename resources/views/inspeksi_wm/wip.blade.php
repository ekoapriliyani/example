<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Input Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref: <span class="font-mono font-bold text-indigo-600">{{ $inspeksi_wm->nomor_inspeksi }}</span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Sedang menginput data WIP untuk transaksi
                            <strong>{{ $inspeksi_wm->nomor_inspeksi }}</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('inspeksi_wm_wip.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_wm_id" value="{{ $inspeksi_wm->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="no_material" :value="__('Nomor Material')" />
                                <x-text-input id="no_material" name="no_material" type="text"
                                    class="mt-1 block w-full" :value="old('no_material')" required
                                    placeholder="Masukkan kode material" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>

                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator')" required
                                    placeholder="Nama operator mesin" />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="d_kawat_act" :value="__('Diameter Kawat (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="d_kawat_act" name="d_kawat_act" type="number" step="0.01"
                                        class="block w-full pr-12" :value="old('d_kawat_act')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('d_kawat_act')" />
                            </div>
                            <div>
                                <x-input-label for="selisih_diagonal" :value="__('Selisih Diagonal (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="selisih_diagonal" name="selisih_diagonal" type="number"
                                        step="1" class="block w-full pr-12" :value="old('selisih_diagonal')" required
                                        placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('selisih_diagonal')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="p_product_act" :value="__('Panjang Produk (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_product_act" name="p_product_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('p_product_act')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_product_act')" />
                            </div>

                            <div>
                                <x-input-label for="l_product_act" :value="__('Lebar Produk (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_product_act" name="l_product_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('l_product_act')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_product_act')" />
                            </div>

                            <div>
                                <x-input-label for="p_mesh_act" :value="__('Panjang Mesh (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="p_mesh_act" name="p_mesh_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('p_mesh_act')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('p_mesh_act')" />
                            </div>

                            <div>
                                <x-input-label for="l_mesh_act" :value="__('Lebar Mesh (Actual)')" />
                                <div class="relative mt-1">
                                    <x-text-input id="l_mesh_act" name="l_mesh_act" type="number" step="1"
                                        class="block w-full pr-12" :value="old('l_mesh_act')" required placeholder="0.00" />
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                        mm
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('l_mesh_act')" />
                            </div>
                            <div>
                                <x-input-label for="torsi_strength" :value="__('Torsi Strength')" />
                                <div class="relative mt-1">
                                    <select id="torsi_strength" name="torsi_strength"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="OK">OK</option>
                                        <option value="NG">NG</option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('torsi_strength')" />
                            </div>
                            <div>
                                <x-input-label for="status_dimensi" :value="__('Dimensi')" />
                                <div class="relative mt-1">
                                    <select id="status_dimensi" name="status_dimensi"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="OK">OK</option>
                                        <option value="NG">NG</option>
                                    </select>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('status_dimensi')" />
                            </div>


                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('inspeksi_wm.show', $inspeksi_wm->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Simpan Data WIP') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
