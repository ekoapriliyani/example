<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_klip->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_klip_wip.update', $wip->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="inspeksi_klip_id"
                            value="{{ old('inspeksi_klip_id', $wip->inspeksi_klip_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="grid grid-cols-3 gap-6 md:grid-cols-3">
                            <div>
                                <x-input-label for="no_material" :value="__('No. Material')" />
                                <x-text-input id="no_material" name="no_material" type="text"
                                    class="mt-1 block w-full" :value="old('no_material', $wip->no_material)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>
                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator', $wip->nama_operator)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                            <div>
                                <x-input-label for="jml_klip" :value="__('Jumlah Klip')" />
                                <x-text-input id="jml_klip" name="jml_klip" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('jml_klip', $wip->jml_klip)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jml_klip')" />
                            </div>
                            <div>
                                <x-input-label for="d_razor" :value="__('Diameter Razor')" />
                                <x-text-input id="d_razor" name="d_razor" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_razor', $wip->d_razor)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_razor')" />
                            </div>
                            <div>
                                <x-input-label for="jml_spiral" :value="__('Jumlah Spiral')" />
                                <x-text-input id="jml_spiral" name="jml_spiral" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('jml_spiral', $wip->jml_spiral)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jml_spiral')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-5 gap-6 md:grid-cols-5">
                            <div>
                                <x-input-label for="jarak_antar_klip1" :value="__('Jarak Antar Klip 1')" />
                                <x-text-input id="jarak_antar_klip1" name="jarak_antar_klip1" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('jarak_antar_klip1', $wip->jarak_antar_klip1)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip1')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip2" :value="__('Jarak Antar Klip 2')" />
                                <x-text-input id="jarak_antar_klip2" name="jarak_antar_klip2" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('jarak_antar_klip2', $wip->jarak_antar_klip2)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip2')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip3" :value="__('Jarak Antar Klip 3')" />
                                <x-text-input id="jarak_antar_klip3" name="jarak_antar_klip3" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('jarak_antar_klip3', $wip->jarak_antar_klip3)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip3')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip4" :value="__('Jarak Antar Klip 4')" />
                                <x-text-input id="jarak_antar_klip4" name="jarak_antar_klip4" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('jarak_antar_klip4', $wip->jarak_antar_klip4)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip4')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_antar_klip5" :value="__('Jarak Antar Klip 5')" />
                                <x-text-input id="jarak_antar_klip5" name="jarak_antar_klip5" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('jarak_antar_klip5', $wip->jarak_antar_klip5)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_antar_klip5')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-6 md:grid-cols-3">
                            <div>
                                <x-input-label for="kerapatan" :value="__('Kerapatan')" />
                                <select id="kerapatan" name="kerapatan"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih kerapatan --</option>
                                    <option value="OK"
                                        {{ old('kerapatan', $wip->kerapatan) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG"
                                        {{ old('kerapatan', $wip->kerapatan) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kerapatan')" />
                            </div>

                            <div>
                                <x-input-label for="visual" :value="__('visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih visual --</option>
                                    <option value="OK" {{ old('visual', $wip->visual) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG" {{ old('visual', $wip->visual) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('visual')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih status --</option>
                                    <option value="OK" {{ old('status', $wip->status) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG"
                                        {{ old('status', $wip->status) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                        </div>


                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="mb-4 font-semibold text-gray-700">Files</h3>
                            {{-- File Lama --}}
                            @if ($wip->files)
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    @foreach ($wip->files as $file)
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
                                @forelse ($wip->details as $detail)
                                    <div class="detail-row grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_klip.wip.options-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_klip.wip.options-detail', [
                                                    'selected' => $detail->description2,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full"
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
                                                @include('inspeksi_klip.wip.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_klip.wip.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('QTY')" />
                                            <x-text-input name="detail_qty[]" type="number"
                                                class="mt-1 block w-full" placeholder="QTY" />
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
                            <a href="{{ route('inspeksi_klip.show', $inspeksi_klip->id) }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm hover:bg-gray-50">
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
        const optionsDetail = `@include('inspeksi_klip.wip.options-detail', ['selected' => null])`;

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
