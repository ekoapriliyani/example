<x-layout>
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-xl font-bold text-gray-800">Daftar Inspeksi WM</h1>

        <a href="{{ route('inspeksi_wm.create') }}"
            class="inline-flex items-center gap-2 rounded bg-teal-600 px-4 py-2 text-sm font-bold text-white hover:bg-teal-700 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Inspeksi
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                <thead class="bg-gray-50 ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">Nomor Inspeksi
                        </th>
                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-900 text-right whitespace-nowrap">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->nomor_inspeksi }}
                            </td>
                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                {{ $item->tanggal }}
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('inspeksi_wm.show', $item->id) }}"
                                    class="inline-block rounded bg-teal-500 px-3 py-1.5 text-xs font-bold text-white hover:bg-teal-600 transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 italic">
                                Belum ada data Inspeksi. Silakan tambah inspeksi baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus mesin?',
                text: "Material " + name + " akan dihapus secara permanen!",
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
        <strong>Inspeksi Page</strong>
    </x-slot:footer>
</x-layout>
