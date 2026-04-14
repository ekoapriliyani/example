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
                    <form action="{{ route('inspeksi_wm_fg.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="inspeksi_wm_id" value="{{ $inspeksi_wm->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="batch_number" :value="__('Batch Number')" />
                                <x-text-input id="batch_number" name="batch_number" type="text"
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
                                    <option value="PASS">PASS</option>
                                    <option value="REJECT">REJECT</option>
                                    <option value="HOLD">HOLD</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
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
</x-app-layout>
