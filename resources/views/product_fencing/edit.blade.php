<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk Fencing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Ubah data Produk Fencing.
                        </p>
                    </div>

                    <form action="{{ route('productfencing.update', $productfencing->id) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="product_fencing_id" :value="__('Product Fencing ID')" />
                            <x-text-input id="product_fencing_id" name="product_fencing_id" type="text"
                                class="mt-1 block w-full" :value="old('product_fencing_id', $productfencing->product_fencing_id)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('product_fencing_id')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full"
                                :value="old('description', $productfencing->description)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="d1" :value="__('Diameter 1')" />
                            <x-text-input id="d1" name="d1" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('d1', $productfencing->d1)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('d1')" />
                        </div>
                        <div>
                            <x-input-label for="d2" :value="__('Diameter 2')" />
                            <x-text-input id="d2" name="d2" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('d2', $productfencing->d2)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('d2')" />
                        </div>

                        <div>
                            <x-input-label for="tol_d1" :value="__('Toleransi D1 (-/+)')" />
                            <x-text-input id="tol_d1" name="tol_d1" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('tol_d1', $productfencing->tol_d1)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tol_d1')" />
                        </div>
                        <div>
                            <x-input-label for="tol_d2" :value="__('Toleransi D2 (-/+)')" />
                            <x-text-input id="tol_d2" name="tol_d2" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('tol_d2', $productfencing->tol_d2)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tol_d2')" />
                        </div>

                        <div>
                            <x-input-label for="p_before" :value="__('Panjang sebelum bending')" />
                            <x-text-input id="p_before" name="p_before" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('p_before', $productfencing->p_before)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('p_before')" />
                        </div>

                        <div>
                            <x-input-label for="p_after" :value="__('Panjang sesudah bending')" />
                            <x-text-input id="p_after" name="p_after" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('p_after', $productfencing->p_after)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('p_after')" />
                        </div>

                        <div>
                            <x-input-label for="l_before" :value="__('Lebar sebelum bending')" />
                            <x-text-input id="l_before" name="l_before" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('l_before', $productfencing->l_before)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('l_before')" />
                        </div>

                        <div>
                            <x-input-label for="l_after" :value="__('Lebar sesudah bending')" />
                            <x-text-input id="l_after" name="l_after" type="number" step="0.01"
                                class="mt-1 block w-full" :value="old('l_after', $productfencing->l_after)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('l_after')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('productfencing.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button>
                                {{ __('Update Product Fencing') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
