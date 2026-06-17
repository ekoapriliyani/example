<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_gabionanyam->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_gabionanyam_wip.update', $wip->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_gabionanyam_id"
                            value="{{ old('inspeksi_gabionanyam_id', $wip->inspeksi_gabionanyam_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-2 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="no_material" :value="__('No. Material')" />
                                <x-text-input id="no_material" name="no_material" type="text"
                                    class="mt-1 block w-full" :value="old('no_material', $wip->no_material)" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>
                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator', $wip->nama_operator)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih type --</option>
                                    <option value="Heavy Galvanized"
                                        {{ old('type', $wip->type) == 'Heavy Galvanized' ? 'selected' : '' }}>
                                        Heavy Galvanized
                                    </option>
                                    <option value="PVC" {{ old('type', $wip->type) == 'PVC' ? 'selected' : '' }}>
                                        PVC
                                    </option>
                                    <option value="HDPE" {{ old('type', $wip->type) == 'HDPE' ? 'selected' : '' }}>
                                        HDPE
                                    </option>
                                    <option value="Bezilum Class 1"
                                        {{ old('type', $wip->type) == 'Bezilum Class 1' ? 'selected' : '' }}>
                                        Bezilum Class 1
                                    </option>
                                    <option value="Bezilum Class 2"
                                        {{ old('type', $wip->type) == 'Bezilum Class 2' ? 'selected' : '' }}>
                                        Bezilum Class 2
                                    </option>
                                    <option value="Bezilum Class 3"
                                        {{ old('type', $wip->type) == 'Bezilum Class 3' ? 'selected' : '' }}>
                                        Bezilum Class 3
                                    </option>
                                    <option value="Light Galvanized"
                                        {{ old('type', $wip->type) == 'Light Galvanized' ? 'selected' : '' }}>
                                        Light Galvanized
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>
                            <div>
                                <x-input-label for="l1_act" :value="__('Lebar 1 Act')" />
                                <x-text-input id="l1_act" name="l1_act" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('l1_act', $wip->l1_act)" />
                                <x-input-error class="mt-2" :messages="$errors->get('l1_act')" />
                            </div>
                            <div>
                                <x-input-label for="l2_act" :value="__('Lebar 2 Act')" />
                                <x-text-input id="l2_act" name="l2_act" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('l2_act', $wip->l2_act)" />
                                <x-input-error class="mt-2" :messages="$errors->get('l2_act')" />
                            </div>
                            <div>
                                <x-input-label for="d_anyam" :value="__('Diameter Anyam')" />
                                <x-text-input id="d_anyam" name="d_anyam" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_anyam', $wip->d_anyam)" />
                                <x-input-error class="mt-2" :messages="$errors->get('d_anyam')" />
                            </div>
                            <div>
                                <x-input-label for="d_frame" :value="__('Diameter Frame')" />
                                <x-text-input id="d_frame" name="d_frame" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_frame', $wip->d_frame)" />
                                <x-input-error class="mt-2" :messages="$errors->get('d_frame')" />
                            </div>
                            <div>
                                <x-input-label for="d_anyam_pvc" :value="__('Diameter Anyam PVC')" />
                                <x-text-input id="d_anyam_pvc" name="d_anyam_pvc" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_anyam_pvc', $wip->d_anyam_pvc)" />
                                <x-input-error class="mt-2" :messages="$errors->get('d_anyam_pvc')" />
                            </div>
                            <div>
                                <x-input-label for="d_frame_pvc" :value="__('Diameter Frame PVC')" />
                                <x-text-input id="d_frame_pvc" name="d_frame_pvc" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_frame_pvc', $wip->d_frame_pvc)" />
                                <x-input-error class="mt-2" :messages="$errors->get('d_frame_pvc')" />
                            </div>

                            <div>
                                <x-input-label for="mesh1" :value="__('Mesh 1')" />
                                <x-text-input id="mesh1" name="mesh1" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh1', $wip->mesh1)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh1')" />
                            </div>
                            <div>
                                <x-input-label for="mesh2" :value="__('Mesh 2')" />
                                <x-text-input id="mesh2" name="mesh2" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('mesh2', $wip->mesh2)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mesh2')" />
                            </div>
                            <div>
                                <x-input-label for="p_lilitan" :value="__('Panjang Lilitan')" />
                                <x-text-input id="p_lilitan" name="p_lilitan" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('p_lilitan', $wip->p_lilitan)" />
                                <x-input-error class="mt-2" :messages="$errors->get('p_lilitan')" />
                            </div>
                            <div>
                                <x-input-label for="jml_lilitan" :value="__('Jumlah Lilitan')" />
                                <x-text-input id="jml_lilitan" name="jml_lilitan" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('jml_lilitan', $wip->jml_lilitan)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jml_lilitan')" />
                            </div>
                            <div>
                                <x-input-label for="visual" :value="__('visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih visual --</option>
                                    <option value="OK"
                                        {{ old('visual', $wip->visual) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG"
                                        {{ old('visual', $wip->visual) == 'NG' ? 'selected' : '' }}>
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
                                    <option value="OK"
                                        {{ old('status', $wip->status) == 'OK' ? 'selected' : '' }}>
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
                                                @include('inspeksi_gabionanyam.wip.options-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_gabionanyam.wip.options-detail', [
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
                                                @include('inspeksi_gabionanyam.wip.options-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_gabionanyam.wip.options-detail', [
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
                            <a href="{{ route('inspeksi_gabionanyam.show', $inspeksi_gabionanyam->id) }}"
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
        const optionsDetail = `@include('inspeksi_gabionanyam.wip.options-detail', ['selected' => null])`;

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
