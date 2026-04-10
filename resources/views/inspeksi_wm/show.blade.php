<x-layout>
    <div class="max-w-4xl mx-auto">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="p-6 sm:p-8">
                <div class="flow-root">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Nomor Inspeksi</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-teal-100 px-2.5 py-0.5 text-teal-700">
                                    {{ $inspeksi_wm->nomor_inspeksi }}
                                </span>
                            </dd>
                        </div>

                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Tanggal</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $inspeksi_wm->tanggal }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="mt-8 rounded-lg border border-red-100 bg-red-50 p-4">
            <div class="flex items-center justify-between">
                <form id="delete-form-{{ $inspeksi_wm->id }}"
                    action="{{ route('inspeksi_wm.destroy', $inspeksi_wm->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        onclick="confirmDelete({{ $inspeksi_wm->id }}, '{{ $inspeksi_wm->nomor_inspeksi }}')"
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
