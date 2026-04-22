<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk WM Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Daftarkan Produk WM baru.
                        </p>
                    </div>

                    <form action="{{ route('productwm.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="product_wm_id" :value="__('Product WM ID')" />
                            <x-text-input id="product_wm_id" name="product_wm_id" type="text"
                                class="mt-1 block w-full" :value="old('product_wm_id')" placeholder="" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('product_wm_id')" />
                        </div>
                        <div>
                            <x-input-label for="jenis_wm" :value="__('Jenis WM')" />
                            <select id="jenis_wm" name="jenis_wm"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Roll" {{ old('jenis_wm') == 'Roll' ? 'selected' : '' }}>Roll</option>
                                <option value="Lembaran" {{ old('jenis_wm') == 'Lembaran' ? 'selected' : '' }}>Lembaran
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_wm')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                                :value="old('description')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                        <div>
                            <x-input-label for="d_kawat" :value="__('Diamter Kawat')" />
                            <x-text-input id="d_kawat" name="d_kawat" type="number" class="mt-1 block w-full"
                                :value="old('d_kawat')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('d_kawat')" />
                        </div>
                        <div>
                            <x-input-label for="tol_min_d" :value="__('Tol Min D')" />
                            <x-text-input id="tol_min_d" name="tol_min_d" type="number" class="mt-1 block w-full"
                                :value="old('tol_min_d')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tol_min_d')" />
                        </div>
                        <div>
                            <x-input-label for="tol_max_d" :value="__('Tol Max D')" />
                            <x-text-input id="tol_max_d" name="tol_max_d" type="number" class="mt-1 block w-full"
                                :value="old('tol_max_d')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tol_max_d')" />
                        </div>
                        <div>
                            <x-input-label for="p_product" :value="__('Panjang Product')" />
                            <x-text-input id="p_product" name="p_product" type="number" class="mt-1 block w-full"
                                :value="old('p_product')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('p_product')" />
                        </div>
                        <div>
                            <x-input-label for="l_product" :value="__('Lebar Product')" />
                            <x-text-input id="l_product" name="l_product" type="number" class="mt-1 block w-full"
                                :value="old('l_product')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('l_product')" />
                        </div>
                        <div>
                            <x-input-label for="p_mesh" :value="__('Panjang Mesh')" />
                            <x-text-input id="p_mesh" name="p_mesh" type="number" class="mt-1 block w-full"
                                :value="old('p_mesh')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('p_mesh')" />
                        </div>
                        <div>
                            <x-input-label for="l_mesh" :value="__('Lebar Mesh')" />
                            <x-text-input id="l_mesh" name="l_mesh" type="number" class="mt-1 block w-full"
                                :value="old('l_mesh')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('l_mesh')" />
                        </div>
                        <div>
                            <x-input-label for="tol_mesh" :value="__('Tol Mesh')" />
                            <x-text-input id="tol_mesh" name="tol_mesh" type="number" class="mt-1 block w-full"
                                :value="old('tol_mesh')" placeholder="" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tol_mesh')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('productwm.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Product WM') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
