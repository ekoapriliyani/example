<!-- Form Inspeksi FG -->
<div class="mt-8 rounded-lg border border-gray-200 bg-white p-6">
    <h2 class="text-lg font-bold mb-4">Form Inspeksi FG</h2>
    <form action="{{ route('inspeksi_fg.store') }}" method="POST">
        @csrf
        <input type="hidden" name="inspeksi_wm_id" value="{{ $inspeksi_wm->id }}">
        <div class="mb-3">
            <label class="block text-sm font-medium">Batch Number</label>
            <input type="text" name="batch_number" class="w-full border rounded px-2 py-1">
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium">Qty</label>
            <input type="number" name="qty" class="w-full border rounded px-2 py-1">
        </div>
        <!-- Tambahkan field lain sesuai kebutuhan -->
        <div class="flex justify-end gap-2">
            <button type="submit" class="px-3 py-1 rounded bg-blue-600 text-white">Simpan</button>
        </div>
    </form>
</div>
