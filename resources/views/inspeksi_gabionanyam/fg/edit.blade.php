<x-app-layout>
    <x-slot name="header">
        <div>
            <nav class="mb-2 flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('inspeksi_gabionanyam.index') }}"
                    class="transition-colors hover:text-indigo-600">Inspeksi Gabion Anyam</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('inspeksi_gabionanyam.show', $inspeksiGabionanyam->id) }}"
                    class="transition-colors hover:text-indigo-600">Detail</a>
                <span class="text-gray-400">/</span>
                <span class="font-medium text-gray-800">Edit FG</span>
            </nav>

            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Edit Hasil Inspeksi FG') }}
                </h2>
                <p class="text-sm text-gray-500">
                    Ref: <span
                        class="font-mono font-bold text-indigo-600">{{ $inspeksiGabionanyam->nomor_inspeksi }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_gabionanyam_fg.update', $fg->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_gabionanyam_fg_id" value="{{ $fg->id }}">
                        <input type="hidden" name="user_id" value="{{ old('user_id', $fg->user_id) }}">

                        <div class="grid grid-cols-2 gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK" {{ old('status', $fg->status) == 'OK' ? 'selected' : '' }}>OK
                                    </option>
                                    <option value="NG" {{ old('status', $fg->status) == 'NG' ? 'selected' : '' }}>NG
                                    </option>
                                    <option value="REJECT"
                                        {{ old('status', $fg->status) == 'REJECT' ? 'selected' : '' }}>REJECT</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="qty" :value="__('Quantity (Unit)')" />
                                <x-text-input id="qty" name="qty" type="number" step="0.01"
                                    class="mt-1 block w-full" value="{{ old('qty', $fg->qty) }}" required
                                    placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>

                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01"
                                    class="mt-1 block w-full" value="{{ old('weight', $fg->weight) }}"
                                    placeholder="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>

                            <div>
                                <x-input-label for="packing" :value="__('Packing')" />
                                <select id="packing" name="packing"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK"
                                        {{ old('packing', $fg->packing) == 'OK' ? 'selected' : '' }}>OK</option>
                                    <option value="NG"
                                        {{ old('packing', $fg->packing) == 'NG' ? 'selected' : '' }}>NG</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('packing')" />
                            </div>

                            <div>
                                <x-input-label for="label" :value="__('Label')" />
                                <select id="label" name="label"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="OK" {{ old('label', $fg->label) == 'OK' ? 'selected' : '' }}>OK
                                    </option>
                                    <option value="NG" {{ old('label', $fg->label) == 'NG' ? 'selected' : '' }}>NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('label')" />
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6 md:col-span-2">
                            <h3 class="mb-4 font-semibold text-gray-700">File / Gambar Existing</h3>

                            @if ($fg->files && count($fg->files) > 0)
                                <div class="mb-4 grid grid-cols-2 gap-4 md:grid-cols-4">
                                    @foreach ($fg->files as $file)
                                        <div class="rounded-lg border bg-gray-50 p-2">
                                            @php
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            @endphp

                                            @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $file) }}" alt="File"
                                                    class="mb-2 h-32 w-full rounded object-cover">
                                            @else
                                                <div
                                                    class="mb-2 flex h-32 items-center justify-center rounded bg-gray-100 text-sm text-gray-600">
                                                    {{ strtoupper($ext) }} FILE
                                                </div>
                                            @endif

                                            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                class="text-sm text-indigo-600 hover:underline">
                                                Lihat File
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="mb-4 text-sm text-gray-500">Belum ada file.</p>
                            @endif

                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload File Baru (Opsional)')" />
                                <input id="files" name="files[]" type="file"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" multiple
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <p class="mt-1 text-xs text-gray-500">
                                    Jika upload file baru, file lama akan diganti.
                                </p>
                                @error('files')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                                @error('files.*')
                                    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6 md:col-span-2">
                            <h3 class="mb-4 font-semibold text-gray-700">Detail Inspeksi</h3>

                            <div id="detail-wrapper" class="space-y-4">
                                @forelse ($fg->details as $index => $detail)
                                    <div
                                        class="detail-row grid grid-cols-1 gap-4 rounded-lg border bg-gray-50 p-4 md:grid-cols-4">
                                        <input type="hidden" name="detail_id[]" value="{{ $detail->id }}">

                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_gabionanyam.fg.options-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_gabionanyam.fg.options-detail', [
                                                    'selected' => $detail->description2,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full"
                                                value="{{ old('detail_qty.' . $index, $detail->qty) }}"
                                                placeholder="QTY" />
                                        </div>

                                        <div class="flex items-end">
                                            <button type="button"
                                                class="remove-detail w-full rounded-md bg-red-500 px-3 py-2 text-sm text-white hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="detail-row grid grid-cols-1 gap-4 rounded-lg border bg-gray-50 p-4 md:grid-cols-4">
                                        <input type="hidden" name="detail_id[]" value="">

                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_gabionanyam.fg.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_gabionanyam.fg.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full" placeholder="QTY" />
                                        </div>

                                        <div class="flex items-end">
                                            <button type="button"
                                                class="remove-detail w-full rounded-md bg-red-500 px-3 py-2 text-sm text-white hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="mt-4">
                                <button type="button" id="add-detail"
                                    class="rounded-md bg-indigo-600 px-3 py-1 text-sm text-white hover:bg-indigo-700">
                                    + Tambah Detail
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('inspeksi_gabionanyam.show', $inspeksiGabionanyam->id) }}"
                                class="text-sm text-gray-600 hover:underline">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                                {{ __('Update Data FG') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const optionsDetail = `@include('inspeksi_gabionanyam.fg.options-detail', ['selected' => null])`;

        document.getElementById('add-detail').addEventListener('click', function() {
            const wrapper = document.getElementById('detail-wrapper');

            const html = `
                <div class="detail-row grid grid-cols-1 md:grid-cols-4 gap-4 border rounded-lg p-4 bg-gray-50">
                    <input type="hidden" name="detail_id[]" value="">

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

                    <div class="flex items-end">
                        <button type="button"
                            class="remove-detail px-3 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 w-full">
                            Hapus
                        </button>
                    </div>
                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', html);
            updateRemoveButtons();
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-detail')) {
                const rows = document.querySelectorAll('.detail-row');
                if (rows.length > 1) {
                    e.target.closest('.detail-row').remove();
                }
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.detail-row');
            const removeButtons = document.querySelectorAll('.remove-detail');

            removeButtons.forEach(btn => {
                btn.disabled = rows.length === 1;
                btn.classList.toggle('opacity-50', rows.length === 1);
                btn.classList.toggle('cursor-not-allowed', rows.length === 1);
            });
        }

        updateRemoveButtons();
    </script>
</x-app-layout>
