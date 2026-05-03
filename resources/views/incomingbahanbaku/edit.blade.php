<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Inspeksi Bahan Baku
            </h2>

            <a href="{{ route('incomingbahanbaku.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8">

                    <form action="{{ route('incomingbahanbaku.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal
                                </label>
                                <input type="date" name="tanggal"
                                    value="{{ old('tanggal', $data->tanggal) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Supplier
                                </label>
                                <select name="supplier_id"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                                    <option value="">Pilih Supplier</option>

                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id', $data->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->supplier_code }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('supplier_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    No PO
                                </label>
                                <input type="text" name="no_po"
                                    value="{{ old('no_po', $data->no_po) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('no_po')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    No SJ
                                </label>
                                <input type="text" name="no_sj"
                                    value="{{ old('no_sj', $data->no_sj) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>

                                @error('no_sj')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Jml Koil
                                </label>
                                <input type="number" name="jml_koil"
                                    value="{{ old('jml_koil', $data->jml_koil) }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('jml_koil')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    D Kawat
                                </label>
                                <input type="number" name="d_kawat"
                                    value="{{ old('d_kawat', $data->d_kawat) }}"
                                    step="0.01"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('d_kawat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Toleransi
                                </label>
                                <input type="number" name="tol"
                                    value="{{ old('tol', $data->tol) }}"
                                    step="0.01"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                                @error('tol')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Kawat
                                </label>
                                <select name="jenis_kawat"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Pilih Jenis Kawat</option>

                                    @foreach (['LG', 'HG', 'ULTRA', 'BLACK WIRE', 'BEZILUM'] as $jk)
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

                        </div>

                        <div class="mt-8 flex justify-end gap-2">
                            <a href="{{ route('incomingbahanbaku.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
