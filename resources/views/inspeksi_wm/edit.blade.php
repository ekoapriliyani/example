<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Inspeksi') }}
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

                    <form action="{{ route('inspeksi_wm.update', $inspeksi_wm->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nomor_inspeksi" :value="__('Nomor Inspeksi (Otomatis)')" />
                            <x-text-input id="nomor_inspeksi" name="nomor_inspeksi" type="text"
                                class="mt-1 block w-full bg-gray-100"
                                value="{{ old('nomor_inspeksi', $inspeksi_wm->nomor_inspeksi) }}" readonly />
                        </div>

                        <div>
                            <x-input-label for="trno" :value="__('PRO Number')" />
                            <select id="trno" name="trno"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih PRO --</option>
                                <option value="1" {{ old('trno', $inspeksi_wm->trno) == '1' ? 'selected' : '' }}>1
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('trno')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <select id="description" name="description"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Description --</option>
                                <option value="1"
                                    {{ old('description', $inspeksi_wm->description) == '1' ? 'selected' : '' }}>1
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="shift" :value="__('Shift')" />
                            <select id="shift" name="shift"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Shift --</option>
                                <option value="shift1"
                                    {{ old('shift', $inspeksi_wm->shift) == 'shift1' ? 'selected' : '' }}>Shift 1
                                </option>
                                <option value="shift2"
                                    {{ old('shift', $inspeksi_wm->shift) == 'shift2' ? 'selected' : '' }}>Shift 2
                                </option>
                                <option value="shift3"
                                    {{ old('shift', $inspeksi_wm->shift) == 'shift3' ? 'selected' : '' }}>Shift 3
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('shift')" />
                        </div>

                        <div>
                            <x-input-label for="grade" :value="__('Grade')" />
                            <select id="grade" name="grade"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Grade --</option>
                                <option value="SNI"
                                    {{ old('grade', $inspeksi_wm->grade) == 'SNI' ? 'selected' : '' }}>
                                    SNI</option>
                                <option value="NON SNI"
                                    {{ old('grade', $inspeksi_wm->grade) == 'NON SNI' ? 'selected' : '' }}>NON SNI
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('grade')" />
                        </div>

                        <div>
                            <x-input-label for="type_coating" :value="__('Type Coating')" />
                            <select id="type_coating" name="type_coating"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Type Coating --</option>
                                <option value="LG"
                                    {{ old('type_coating', $inspeksi_wm->type_coating) == 'LG' ? 'selected' : '' }}>LG
                                </option>
                                <option value="HG"
                                    {{ old('type_coating', $inspeksi_wm->type_coating) == 'HG' ? 'selected' : '' }}>HG
                                </option>
                                <option value="ZN-AL"
                                    {{ old('type_coating', $inspeksi_wm->type_coating) == 'ZN-AL' ? 'selected' : '' }}>
                                    ZN-AL
                                </option>
                                <option value="ULTRA"
                                    {{ old('type_coating', $inspeksi_wm->type_coating) == 'ULTRA' ? 'selected' : '' }}>
                                    ULTRA
                                </option>
                                <option value="BLACK"
                                    {{ old('type_coating', $inspeksi_wm->type_coating) == 'BLACK' ? 'selected' : '' }}>
                                    BLACK
                                </option>
                                <option value="EP"
                                    {{ old('type_coating', $inspeksi_wm->type_coating) == 'EP' ? 'selected' : '' }}>EP
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type_coating')" />
                        </div>

                        <div>
                            <x-input-label for="shear_strength" :value="__('Shear Strength')" />
                            <div class="relative mt-1">
                                <x-text-input id="shear_strength" name="shear_strength" type="number" step="1"
                                    class="block w-full pr-12" :value="old('shear_strength', $inspeksi_wm->shear_strength)" required placeholder="0.00" />
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 text-sm">
                                    mm
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('shear_strength')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('inspeksi_wm.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
</x-app-layout>
