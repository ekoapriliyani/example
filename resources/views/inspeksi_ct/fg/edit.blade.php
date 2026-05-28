<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Hasil Inspeksi FG') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_ct->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_ct_fg.update', $fg->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_fg_id"
                            value="{{ old('inspeksi_ct_id', $fg->inspeksi_ct_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="OK" {{ old('status', $fg->status) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG" {{ old('status', $fg->status) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                    <option value="REJECT"
                                        {{ old('status', $fg->status) == 'REJECT' ? 'selected' : '' }}>
                                        REJECT
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                            <div>
                                <x-input-label for="qty" :value="__('Quantity')" />
                                <x-text-input id="qty" name="qty" type="number" class="mt-1 block w-full"
                                    :value="old('qty', $fg->qty)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('qty')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('weight', $fg->weight)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>
                            <div>
                                <x-input-label for="packing" :value="__('Packing')" />
                                <select id="packing" name="packing"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="OK" {{ old('packing', $fg->packing) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG" {{ old('packing', $fg->packing) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('packing')" />
                            </div>
                            <div>
                                <x-input-label for="label" :value="__('Label')" />
                                <select id="label" name="label"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="OK" {{ old('label', $fg->label) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG" {{ old('label', $fg->label) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('label')" />
                            </div>
                        </div>
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="mb-4 font-semibold text-gray-700">Files</h3>

                            {{-- File Lama --}}
                            @if ($fg->files)
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                    @foreach ($fg->files as $file)
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
                                @forelse ($fg->details as $detail)
                                    <div class="detail-row grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_ct.fg.options-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_ct.fg.options-detail', [
                                                    'selected' => $detail->description2,
                                                ])
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number" class="mt-1 block w-full"
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
                                                @include('inspeksi_ct.fg.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_ct.fg.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number" class="mt-1 block w-full"
                                                placeholder="QTY" />
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
                            <a href="{{ route('inspeksi_ct.show', $inspeksi_ct->id) }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Update Data FG') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const optionsDetail = `@include('inspeksi_ct.fg.options-detail', ['selected' => null])`;

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
