<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Inspeksi Outgoing
            </h2>

            <a href="{{ route('outgoing.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">

                    <form action="{{ route('outgoing.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Nomor Inspeksi
                                </label>
                                <input type="text" name="nomor_inspeksi" readonly
                                    value="{{ old('nomor_inspeksi', $data->nomor_inspeksi) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                @error('nomor_inspeksi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Tanggal
                                </label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Shipment
                                </label>
                                <select name="shipment_id" id="shipment_id" required>
                                    <option value=""></option>
                                    <!-- Biarkan kosong agar placeholder select2 berfungsi -->
                                    @foreach ($shipments as $shipment)
                                        <option value="{{ $shipment->id }}"
                                            {{ old('shipment_id', $data->shipment_id ?? '') == $shipment->id ? 'selected' : '' }}>
                                            {{ $shipment->shipment_id }} - {{ $shipment->custname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shipment_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Nomor DO
                                </label>
                                <input type="text" name="no_do" value="{{ old('no_do', $data->no_do) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                @error('no_do')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Produk
                                </label>
                                <input type="text" name="produk" value="{{ old('produk', $data->produk) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                @error('produk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Lokasi
                                </label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $data->lokasi) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    No Kendaraan
                                </label>
                                <input type="text" name="no_kendaraan"
                                    value="{{ old('no_kendaraan', $data->no_kendaraan) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                @error('no_kendaraan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Keterangan
                                </label>
                                <input type="text" name="keterangan"
                                    value="{{ old('keterangan', $data->keterangan) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('keterangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    File / Gambar Lama
                                </label>
                                @if ($data->files && count($data->files))
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach ($data->files as $file)
                                            @php
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            @endphp
                                            <div class="rounded-lg border bg-gray-50 p-3">
                                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <img src="{{ asset('storage/' . $file) }}"
                                                        class="h-48 w-full rounded border object-contain">
                                                @elseif ($ext === 'pdf')
                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                        class="text-sm text-indigo-600 hover:underline">
                                                        Lihat PDF: {{ basename($file) }}
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                        class="text-sm text-indigo-600 hover:underline">
                                                        Download: {{ basename($file) }}
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p
                                        class="rounded-md border border-dashed border-gray-300 p-4 text-sm italic text-gray-400">
                                        Tidak ada surat jalan lama.
                                    </p>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Upload Surat Jalan Baru
                                </label>
                                <input type="file" name="files[]" multiple
                                    class="block w-full rounded-md border border-gray-300 p-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">
                                    Jika upload file baru, file lama akan otomatis dihapus dan diganti.
                                </p>
                                @error('files.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end gap-2">
                            <a href="{{ route('outgoing.index') }}"
                                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-indigo-700 active:bg-indigo-900">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#shipment_id').select2({
                placeholder: '-- Pilih shipment --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>
