<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Sheet Galvanized
            </h2>

            <a href="{{ route('sheetgalvanize.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">

                    <form action="{{ route('sheetgalvanize.update', $sheetgalvanize->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Nomor Inspeksi
                                </label>
                                <input type="text" name="nomor_inspeksi"
                                    value="{{ old('nomor_inspeksi', $sheetgalvanize->nomor_inspeksi) }}"
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
                                <input type="date" name="tanggal"
                                    value="{{ old('tanggal', $sheetgalvanize->tanggal) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Supplier
                                </label>
                                <select name="supplier_id"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                    <option value="">Pilih Supplier</option>

                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id', $sheetgalvanize->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('supplier_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    No PO
                                </label>
                                <input type="text" name="no_po" value="{{ old('no_po', $sheetgalvanize->no_po) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('no_po')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    No SJ
                                </label>
                                <input type="text" name="no_sj" value="{{ old('no_sj', $sheetgalvanize->no_sj) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('no_sj')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Certificate
                                </label>
                                <input type="text" name="certificate"
                                    value="{{ old('certificate', $sheetgalvanize->certificate) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('certificate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    File / Gambar Lama
                                </label>
                                @if ($sheetgalvanize->files && count($sheetgalvanize->files))
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach ($sheetgalvanize->files as $file)
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
                                        Tidak ada file lama.
                                    </p>
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Upload File Baru
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
                            <a href="{{ route('sheetgalvanize.index') }}"
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
</x-app-layout>
