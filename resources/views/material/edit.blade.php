<x-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Edit Data Material</h1>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi teknis untuk material: <span
                    class="font-semibold text-indigo-600">{{ $material->item_id }}</span>
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            <form action="{{ route('material.update', $material->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="item_id" class="block text-xs font-medium text-gray-700">Item ID</label>
                    <input type="text" name="item_id" id="item_id"
                        class="mt-1 w-full rounded-md shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('item_id') border-red-500 @enderror"
                        value="{{ old('item_id', $material->item_id) }}" placeholder="Contoh: MSN-001">

                    @error('item_id')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-medium text-gray-700">Description</label>
                    <input type="text" name="description" id="description"
                        class="mt-1 w-full rounded-md shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                        value="{{ old('description', $material->description) }}"
                        placeholder="Contoh: CNC Milling Machine">

                    @error('description')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('material.index') }}"
                        class="inline-block rounded-md px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-block rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot:footer>
        <strong>Edit Material Page</strong>
    </x-slot:footer>
</x-layout>
