<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Inspeksi Bahan Baku
            </h2>

            <a href="{{ route('incomingbahanbaku.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">

                    <form action="{{ route('incomingbahanbaku.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Jenis
                                </label>
                                <div class="flex items-center gap-4 mt-1">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="jenis" value="reguler" required
                                            {{ old('jenis', $data->jenis) == 'reguler' ? 'checked' : '' }}
                                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Reguler</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="jenis" value="non_reguler"
                                            {{ old('jenis', $data->jenis) == 'non_reguler' ? 'checked' : '' }}
                                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Non Reguler (Jika Stock
                                            Opname/dll)</span>
                                    </label>
                                </div>

                                @error('jenis')
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
                                            {{ old('supplier_id', $data->supplier_id) == $supplier->id ? 'selected' : '' }}>
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
                                    No RCR
                                </label>
                                <select id="no_rcr" name="no_rcr"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Pilih No RCR --</option>

                                    @foreach ($receivingData as $row)
                                        <option value="{{ $row['trno'] }}"
                                            data-order-no="{{ $row['OrderNo'] }}"
                                            data-description="{{ $row['description'] }}"
                                            data-total-koil="{{ $row['TotalKoil'] }}"
                                            {{ old('no_rcr', $data->no_rcr) == $row['trno'] ? 'selected' : '' }}>
                                            {{ $row['trno'] }} - {{ $row['OrderNo'] }} - {{ $row['description'] }} -
                                            {{ $row['TotalKoil'] }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('no_rcr')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="3"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Deskripsi...">{{ old('description', $data->description) }}</textarea>

                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    No PO
                                </label>
                                <input type="text" name="no_po" value="{{ old('no_po', $data->no_po) }}"
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
                                <input type="text" name="no_sj" value="{{ old('no_sj', $data->no_sj) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('no_sj')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Jml Koil
                                </label>
                                <input type="number" name="jml_koil" value="{{ old('jml_koil', $data->jml_koil) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('jml_koil')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    D Kawat
                                </label>
                                <input type="number" name="d_kawat" value="{{ old('d_kawat', $data->d_kawat) }}"
                                    step="0.01"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('d_kawat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Toleransi
                                </label>
                                <input type="number" name="tol" value="{{ old('tol', $data->tol) }}"
                                    step="0.01"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('tol')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Jenis Kawat
                                </label>
                                <select name="jenis_kawat"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Pilih Jenis Kawat</option>

                                    @foreach (['LG', 'HG', 'ULTRA', 'BLACK WIRE', 'BEZILUM', 'EP'] as $jk)
                                        <option value="{{ $jk }}"
                                            {{ old('jenis_kawat', $data->jenis_kawat) == $jk ? 'selected' : '' }}>
                                            {{ $jk }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('jenis_kawat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Certificate
                                </label>
                                <input type="text" name="certificate"
                                    value="{{ old('certificate', $data->certificate) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('certificate')
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
                            <a href="{{ route('incomingbahanbaku.index') }}"
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

            $('#no_rcr').select2({
                placeholder: '-- Pilih No RCR --',
                allowClear: true,
                width: '100%'
            });

            $('#no_rcr').on('change', function() {
                var selected = $(this).find(':selected');

                $('#no_po').val(selected.data('order-no') || '');
                $('#description').val(selected.data('description') || '');
                $('#jml_koil').val(selected.data('total-koil') || '');
            });
        });
    </script>
</x-app-layout>
