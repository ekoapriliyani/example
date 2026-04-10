<x-layout>


    <!-- Form Inspeksi WIP -->
    <a href="{{ route('inspeksi_wm.show', $inspeksi_wm->id) }}" class="px-2 py-2 rounded bg-amber-500">Kembali</a>
    <div class="mt-8 rounded-lg border border-gray-200 bg-white p-6">
        <h2 class="text-lg font-bold mb-4">Form Inspeksi WIP</h2>
        <form action="{{ route('inspeksi_wm_wip.store') }}" method="POST">
            @csrf
            <input type="hidden" name="inspeksi_wm_id" value="{{ $inspeksi_wm->id }}">
            <div class="mb-3">
                <label class="block text-sm font-medium">No Material</label>
                <input type="number" name="no_material" class="w-full border rounded px-2 py-1">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Nama Operator</label>
                <input type="text" name="nama_operator" class="w-full border rounded px-2 py-1">
            </div>
            <!-- Tambahkan field lain sesuai kebutuhan -->

            <div class="flex justify-end gap-2">
                <button type="submit" class="px-3 py-1 rounded bg-teal-600 text-white">Simpan</button>
            </div>
        </form>
    </div>
    <x-slot:footer>
        <strong>Inspeksi WM WIP Page</strong>
    </x-slot:footer>
</x-layout>
