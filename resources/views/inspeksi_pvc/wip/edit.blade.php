<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Hasil Inspeksi WIP') }}
            </h2>
            <p class="text-sm text-gray-500">
                Ref:
                <span class="font-mono font-bold text-indigo-600">
                    {{ $inspeksi_pvc->nomor_inspeksi }}
                </span>
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <form action="{{ route('inspeksi_pvc_wip.update', $wip->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="inspeksi_wip_id"
                            value="{{ old('inspeksi_pvc_id', $wip->inspeksi_pvc_id) }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <div class="grid grid-cols-2 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="no_material" :value="__('No. Material Kawat')" />
                                <x-text-input id="no_material" name="no_material" type="text"
                                    class="mt-1 block w-full" :value="old('no_material', $wip->no_material)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material')" />
                            </div>
                            <div>
                                <x-input-label for="no_material2" :value="__('No. Material Bubuk')" />
                                <x-text-input id="no_material2" name="no_material2" type="text"
                                    class="mt-1 block w-full" :value="old('no_material2', $wip->no_material2)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('no_material2')" />
                            </div>
                            <div>
                                <x-input-label for="nama_operator" :value="__('Nama Operator')" />
                                <x-text-input id="nama_operator" name="nama_operator" type="text"
                                    class="mt-1 block w-full" :value="old('nama_operator', $wip->nama_operator)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_operator')" />
                            </div>
                            <div>
                                <x-input-label for="c1" :value="__('Temperatur Cylinder 1')" />
                                <x-text-input id="c1" name="c1" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('c1', $wip->c1)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('c1')" />
                            </div>
                            <div>
                                <x-input-label for="c2" :value="__('Temperatur Cylinder 2')" />
                                <x-text-input id="c2" name="c2" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('c2', $wip->c2)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('c2')" />
                            </div>
                            <div>
                                <x-input-label for="c3" :value="__('Temperatur Cylinder 3')" />
                                <x-text-input id="c3" name="c3" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('c3', $wip->c3)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('c3')" />
                            </div>
                            <div>
                                <x-input-label for="c4" :value="__('Temperatur Cylinder 4')" />
                                <x-text-input id="c4" name="c4" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('c4', $wip->c4)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('c4')" />
                            </div>
                            <div>
                                <x-input-label for="ch" :value="__('Cross Head')" />
                                <x-text-input id="ch" name="ch" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('ch', $wip->ch)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('ch')" />
                            </div>
                            <div>
                                <x-input-label for="d_kawat_inti" :value="__('D Kawat Inti')" />
                                <x-text-input id="d_kawat_inti" name="d_kawat_inti" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_kawat_inti', $wip->d_kawat_inti)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_kawat_inti')" />
                            </div>
                            <div>
                                <x-input-label for="d_kawat_pvc" :value="__('D Kawat PVC/HDPE')" />
                                <x-text-input id="d_kawat_pvc" name="d_kawat_pvc" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('d_kawat_pvc', $wip->d_kawat_pvc)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('d_kawat_pvc')" />
                            </div>
                            <div>
                                <x-input-label for="penyimpangan" :value="__('Penyimpangan')" />
                                <x-text-input id="penyimpangan" name="penyimpangan" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('penyimpangan', $wip->penyimpangan)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('penyimpangan')" />
                            </div>

                            <div>
                                <x-input-label for="warna" :value="__('warna')" />
                                <select id="warna" name="warna"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih warna --</option>
                                    <option value="Abu-Abu"
                                        {{ old('warna', $wip->warna) == 'Abu-Abu' ? 'selected' : '' }}>
                                        Abu-Abu
                                    </option>
                                    <option value="Biru" {{ old('warna', $wip->warna) == 'Biru' ? 'selected' : '' }}>
                                        Biru
                                    </option>
                                    <option value="Hijau"
                                        {{ old('warna', $wip->warna) == 'Hijau' ? 'selected' : '' }}>
                                        Hijau
                                    </option>
                                    <option value="Hitam"
                                        {{ old('warna', $wip->warna) == 'Hitam' ? 'selected' : '' }}>
                                        Hitam
                                    </option>
                                    <option value="Putih"
                                        {{ old('warna', $wip->warna) == 'Putih' ? 'selected' : '' }}>
                                        Putih
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('warna')" />
                            </div>

                            <div>
                                <x-input-label for="uji_lilit" :value="__('uji_lilit')" />
                                <select id="uji_lilit" name="uji_lilit"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih uji_lilit --</option>
                                    <option value="OK"
                                        {{ old('uji_lilit', $wip->uji_lilit) == 'OK' ? 'selected' : '' }}>
                                        OK
                                    </option>
                                    <option value="NG"
                                        {{ old('uji_lilit', $wip->uji_lilit) == 'NG' ? 'selected' : '' }}>
                                        NG
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('uji_lilit')" />
                            </div>
                            <div>
                                <x-input-label for="visual" :value="__('Visual')" />
                                <select id="visual" name="visual"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">-- Pilih Visual --</option>
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
                                                @include('inspeksi_pvc.wip.option-detail', [
                                                    'selected' => $detail->description,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_pvc.wip.option-detail', [
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
                                                @include('inspeksi_pvc.wip.option-detail', [
                                                    'selected' => null,
                                                ])
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Description 2')" />
                                            <select name="detail_description2[]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @include('inspeksi_pvc.wip.option-detail', [
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
                            <a href="{{ route('inspeksi_pvc.show', $inspeksi_pvc->id) }}"
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
        const optionsDetail = `@include('inspeksi_pvc.wip.option-detail', ['selected' => null])`;

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
