<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Daftar Inspeksi Fencing') }}
            </h2>

            <a href="{{ route('inspeksi_fencing.create') }}"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Inspeksi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <div class="overflow-hidden border border-gray-200 bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('inspeksi_fencing.index') }}" method="GET" class="flex gap-2">
                    <div class="relative max-w-md flex-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder-gray-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                            placeholder="Cari nomor inspeksi atau tanggal...">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('inspeksi_fencing.index') }}"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
            <div class="overflow-hidden border border-gray-200 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-16 px-4 py-3 text-left font-semibold text-gray-900">No</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-900">Aksi</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Nomor Inspeksi</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Tanggal</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Shift</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">PRO Number</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Description</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">QTY Ordered</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Total Prod</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Mesin</th>
                                        <th class="px-4 py-3 text-right font-semibold text-gray-900">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="transition-colors hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration + ($data->firstItem() - 1) }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- View (selalu tampil) -->
                                                    <a href="{{ route('inspeksi_fencing.show', $item->id) }}"
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded bg-indigo-50 text-indigo-700 transition hover:bg-indigo-100"
                                                        title="View Details">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    @if (!$item->isApproved())
                                                        <!-- Edit -->
                                                        <a href="{{ route('inspeksi_fencing.edit', $item->id) }}"
                                                            class="inline-flex h-8 w-8 items-center justify-center rounded bg-yellow-50 text-yellow-700 transition hover:bg-yellow-100"
                                                            title="Edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                            </svg>
                                                        </a>
                                                        <!-- Delete -->
                                                        <button type="button"
                                                            onclick="confirmDelete({{ $item->id }}, '{{ $item->nomor_inspeksi }}')"
                                                            class="inline-flex h-8 w-8 items-center justify-center rounded bg-red-50 text-red-700 transition hover:bg-red-100"
                                                            title="Delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                            </svg>
                                                        </button>
                                                        <form id="delete-form-{{ $item->id }}"
                                                            action="{{ route('inspeksi_fencing.destroy', $item->id) }}"
                                                            method="POST" class="hidden">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @else
                                                        <!-- Lock badge -->
                                                        <span
                                                            class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500"
                                                            title="Data terkunci karena sudah approved">
                                                            🔒 Locked
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->nomor_inspeksi }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->tanggal }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->shift }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->pro->pro_id }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->pro->description }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->pro->qty }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $item->total_prod }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->mesin->mesin_id }}
                                            </td>

                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                @if ($item->isApproved())
                                                    <span
                                                        class="inline-block rounded bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                        Approved
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-block rounded bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center italic text-gray-500">
                                                Belum ada data inspeksi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Notifikasi Sukses
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

        // Konfirmasi Hapus
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus data inspeksi?',
                text: "Nomor " + name + " akan dihapus secara permanen!",
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
