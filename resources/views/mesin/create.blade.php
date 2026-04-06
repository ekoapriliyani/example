<x-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Tambah Mesin Baru</h1>
            <p class="mt-1 text-sm text-gray-500">
                Daftarkan aset mesin baru ke dalam sistem inventori produksi.
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <form action="{{ route('mesin.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="id_mesin" class="block text-xs font-medium text-gray-700">ID Mesin</label>
                    <input type="text" name="id_mesin" id="id_mesin"
                        class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500 @error('id_mesin') border-red-500 @enderror"
                        value="{{ old('id_mesin') }}" placeholder="Contoh: MSN-001">

                    @error('id_mesin')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_mesin" class="block text-xs font-medium text-gray-700">Nama Mesin</label>
                    <input type="text" name="nama_mesin" id="nama_mesin"
                        class="mt-1 w-full rounded-md border-gray-200 shadow-sm sm:text-sm focus:border-teal-500 focus:ring-teal-500 @error('nama_mesin') border-red-500 @enderror"
                        value="{{ old('nama_mesin') }}" placeholder="Contoh: High Speed Milling">

                    @error('nama_mesin')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan input:</h3>
                                <ul class="mt-2 list-disc list-inside text-xs text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('mesin.index') }}"
                        class="inline-block rounded-md px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700 shadow-sm">
                        Simpan Mesin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot:footer>
        <strong>Create Mesin Page</strong>
    </x-slot:footer>
</x-layout>
