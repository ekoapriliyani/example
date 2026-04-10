<x-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Tambah Inspeksi Baru</h1>
            <p class="mt-1 text-sm text-gray-500">
                xxxx
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <form action="{{ route('inspeksi_wm.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nomor_inspeksi" class="block text-xs font-medium text-gray-700">Nomor Inspeksi</label>
                    <input type="text" name="nomor_inspeksi" id="nomor_inspeksi"
                        class="mt-1 w-full rounded-md shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500 @error('nomor_inspeksi') border-red-500 @enderror"
                        value="{{ old('nomor_inspeksi') }}" placeholder="Contoh: MSN-001">

                    @error('nomor_inspeksi')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal" class="block text-xs font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal"
                        class="mt-1 w-full rounded-md shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500 @error('tanggal') border-red-500 @enderror"
                        value="{{ old('tanggal') }}" placeholder="Contoh: High Speed Milling">

                    @error('tanggal')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('inspeksi_wm.index') }}"
                        class="inline-block rounded-md px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700 shadow-sm">
                        Simpan Inspeksi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot:footer>
        <strong>Create Inspeksi Wm Page</strong>
    </x-slot:footer>
</x-layout>
