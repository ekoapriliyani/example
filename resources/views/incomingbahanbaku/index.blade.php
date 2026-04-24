<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Inspeksi Incoming Bahan Baku') }}
            </h2>

            <a href="{{ route('incomingbahanbaku.create') }}"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Inspeksi Bahan Baku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                <form action="{{ route('incomingbahanbaku.index') }}" method="GET" class="flex gap-2">
                    <div class="relative flex-1 max-w-md">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Cari nomor inspeksi atau tanggal...">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('incomingbahanbaku.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left w-16">No</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tanggal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Nomor Inspeksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Supplier</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No PO</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No SJ</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jml Koil</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jenis Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Created At</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->tanggal }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nomor_inspeksi }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->supplier->nama }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->no_po }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->no_sj }}
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->jml_koil }}
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->d_kawat }}
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->tol }}
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->jenis_kawat }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->created_at }}
                                            </td>

                                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                                <a href="{{ route('incomingbahanbaku.show', $item->id) }}"
                                                    class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                                    View Details
                                                </a>
                                                <a href="{{ route('incomingbahanbaku.edit', $item->id) }}"
                                                    class="inline-block rounded bg-yellow-50 px-3 py-1.5 text-xs font-bold text-indigo-700 hover:bg-yellow-100 transition">
                                                    Edit
                                                </a>
                                                <button type="button"
                                                    onclick="confirmDelete({{ $item->id }}, '{{ $item->nomor_inspeksi }}')"
                                                    class="inline-block rounded bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-100 transition">
                                                    Delete
                                                </button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('incomingbahanbaku.destroy', $item->id) }}"
                                                    method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 italic">
                                                Belum ada data inspeksi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- <div class="mt-4">
                        {{ $data->links() }}
                    </div> --}}
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
