<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Pengecekan Lab
            </h2>

            <a href="{{ route('mesin.create') }}"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Pengecekan Lab
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">No
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">Tanggal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">Inspektor</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">Nomor PRO</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Nama Mesin</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-right whitespace-nowrap">
                                            Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $item->mesin_id }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->nama_mesin }}
                                            </td>
                                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                                <a href="{{ route('mesin.show', $item->id) }}"
                                                    class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                                    View Details
                                                </a>

                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('mesin.destroy', $item->id) }}" method="POST"
                                                    class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 italic">
                                                Belum ada data mesin. Silakan tambah mesin baru.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. Notifikasi Sukses (Add, Edit, Delete)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        @endif

        // 2. Konfirmasi Hapus (Tetap dipertahankan)
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus mesin?',
                text: "Mesin " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
