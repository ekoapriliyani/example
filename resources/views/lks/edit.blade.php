<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Edit LKS') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <div class="mb-4 p-4 bg-gray-50 rounded-lg border">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Nomor LKS:</span>
                        <span class="text-indigo-600 font-bold">{{ $lks->nomor_lks }}</span>
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-semibold">Supplier:</span> {{ $lks->supplier->nama ?? 'N/A' }}
                    </p>
                </div>

                <form action="{{ route('lks.update', $lks->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="4"
                            class="w-full border rounded px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Keterangan umum LKS (opsional)">{{ old('keterangan', $lks->keterangan) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('lks.show', $lks->id) }}"
                            class="px-4 py-2 bg-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-400 transition">
                            Batal
                        </a>
                        <button
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
