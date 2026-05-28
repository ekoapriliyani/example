<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_kawat_duri->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_kawat_duri_wip.update', $wip->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_kawat_duri_id"
                            value="{{ old('inspeksi_kawat_duri_id', $wip->inspeksi_kawat_duri_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-2 gap-6 md:grid-cols-2">
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
                                <x-input-label for="d_inti_kd" :value="__('Diameter Kawat Inti')" />
                                <x-text-input id="d_inti_kd" name="d_inti_kd" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_inti_kd', $wip->d_inti_kd)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_inti_kd')" />
                            </div>
                            <div>
                                <x-input-label for="d_pvc_kd" :value="__('Diameter Kawat PVC')" />
                                <x-text-input id="d_pvc_kd" name="d_pvc_kd" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_pvc_kd', $wip->d_pvc_kd)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_pvc_kd')" />
                            </div>
                            <div>
                                <x-input-label for="d_inti_kj" :value="__('Diameter Inti Kawat Jalinan')" />
                                <x-text-input id="d_inti_kj" name="d_inti_kj" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_inti_kj', $wip->d_inti_kj)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_inti_kj')" />
                            </div>
                            <div>
                                <x-input-label for="d_pvc_kj" :value="__('Diameter PVC Kawat Jalinan')" />
                                <x-text-input id="d_pvc_kj" name="d_pvc_kj" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_pvc_kj', $wip->d_pvc_kj)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_pvc_kj')" />
                            </div>
                            <div>
                                <x-input-label for="jarak_duri" :value="__('Jarak Duri')" />
                                <x-text-input id="jarak_duri" name="jarak_duri" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('jarak_duri', $wip->jarak_duri)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jarak_duri')" />
                            </div>
                            <div>
                                <x-input-label for="jml_jalinan_duri" :value="__('Jumlah Jalinan Duri')" />
                                <x-text-input id="jml_jalinan_duri" name="jml_jalinan_duri" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('jml_jalinan_duri', $wip->jml_jalinan_duri)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jml_jalinan_duri')" />
                            </div>
                            <div>
                                <x-input-label for="sudut_ujung_duri" :value="__('Sudut Ujung Duri')" />
                                <x-text-input id="sudut_ujung_duri" name="sudut_ujung_duri" type="number"
                                    step="0.01" class="mt-1 block w-full" :value="old('sudut_ujung_duri', $wip->sudut_ujung_duri)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('sudut_ujung_duri')" />
                            </div>
                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-text-input id="weight" name="weight" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('weight', $wip->weight)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>
                            <div>
                                <x-input-label for="jml_counter" :value="__('Jumlah Counter')" />
                                <x-text-input id="jml_counter" name="jml_counter" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('jml_counter', $wip->jml_counter)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jml_counter')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="OK" {{ old('status', $wip->status) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG" {{ old('status', $wip->status) == 'NG' ? 'selected' : '' }}>
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
                                @forelse ($wip->inspeksiKdWipDetails as $detail)
                                    <div class="detail-row grid grid-cols-1 gap-4 md:grid-cols-3">
                                        <div>
                                            <x-input-label :value="__('Description')" />
                                            <select name="detail_description[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_kawat_duri.wip.options-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_kawat_duri.wip.options-detail', [
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
                                                @include('inspeksi_kawat_duri.wip.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_kawat_duri.wip.options-detail', [
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
                            <a href="{{ route('inspeksi_kawat_duri.show', $inspeksi_kawat_duri->id) }}"
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
        const optionsDetail = `@include('inspeksi_kawat_duri.wip.options-detail', ['selected' => null])`;

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
