<x-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Detail Informasi Mesin</h1>
                <p class="mt-1 text-sm text-gray-500">Informasi teknis dan spesifikasi mesin produksi.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('mesin.index') }}"
                    class="inline-flex items-center gap-2 rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('mesin.edit', $mesin->id) }}"
                    class="inline-flex items-center gap-2 rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 transition text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Mesin
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="p-6 sm:p-8">
                <div class="flow-root">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">ID Mesin</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-teal-100 px-2.5 py-0.5 text-teal-700">
                                    {{ $mesin->id_mesin }}
                                </span>
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Nama Mesin</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $mesin->nama_mesin }}</dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Terdaftar Pada</dt>
                            <dd class="text-gray-600 sm:col-span-2 italic">
                                {{ $mesin->created_at->format('d M Y, H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-lg border border-red-100 bg-red-50 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-red-800">Zona Berbahaya</h3>
                    <p class="text-xs text-red-600 mt-1">Berhati-hatilah, data mesin ini akan dihapus secara permanen.
                    </p>
                </div>

                <form id="delete-form-{{ $mesin->id }}" action="{{ route('mesin.destroy', $mesin->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete({{ $mesin->id }}, '{{ $mesin->nama_mesin }}')"
                        class="rounded bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700 transition shadow-sm">
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus mesin?',
                text: "Mesin " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

    <x-slot:footer>
        <strong>Mesin Detail Page</strong>
    </x-slot:footer>
</x-layout>
