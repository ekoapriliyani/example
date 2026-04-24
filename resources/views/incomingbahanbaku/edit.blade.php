<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Inspeksi Bahan Baku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <form action="{{ route('incomingbahanbaku.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Supplier -->
                    <div class="mb-4">
                        <label>Supplier</label>
                        <select name="supplier_id" class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $data->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->supplier_code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No PO -->
                    <div class="mb-4">
                        <label>No PO</label>
                        <input type="text" name="no_po" value="{{ old('no_po', $data->no_po) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- No SJ -->
                    <div class="mb-4">
                        <label>No SJ</label>
                        <input type="text" name="no_sj" value="{{ old('no_sj', $data->no_sj) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Jml Koil -->
                    <div class="mb-4">
                        <label>Jml Koil</label>
                        <input type="number" name="jml_koil" value="{{ old('jml_koil', $data->jml_koil) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- D Kawat -->
                    <div class="mb-4">
                        <label>D Kawat</label>
                        <input type="number" name="d_kawat" value="{{ old('d_kawat', $data->d_kawat) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Toleransi -->
                    <div class="mb-4">
                        <label>Toleransi</label>
                        <input type="number" name="tol" value="{{ old('tol', $data->tol) }}"
                            class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Jenis Kawat -->
                    <div class="mb-4">
                        <label>Jenis Kawat</label>
                        <select name="jenis_kawat" class="w-full border rounded px-3 py-2">
                            @foreach (['LG', 'HG', 'ULTRA', 'BLACK WIRE', 'BEZILUM'] as $jk)
                                <option value="{{ $jk }}"
                                    {{ old('jenis_kawat', $data->jenis_kawat) == $jk ? 'selected' : '' }}>
                                    {{ $jk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('incomingbahanbaku.index') }}" class="px-4 py-2 bg-gray-300 rounded">
                            Batal
                        </a>

                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
