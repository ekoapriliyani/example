<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Mesin
            </h2>

            <a href="{{ route('mesin.create') }}"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Mesin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Import Mesin --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-sm font-bold text-gray-700 uppercase mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Import Mesin via Excel
                    </h3>

                    <form action="{{ route('mesin.import') }}" method="POST" enctype="multipart/form-data"
                        class="flex items-end gap-4">
                        @csrf

                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">
                                Pilih File (.xlsx / .csv)
                            </label>
                            <input type="file" name="file" accept=".xlsx, .xls, .csv" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-md focus:outline-none" />
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 transition ease-in-out duration-150">
                            Upload & Proses
                        </button>
                    </form>

                    <p class="mt-2 text-xs text-gray-400 font-medium">
                        * Format kolom:
                        <span class="text-indigo-600 italic">mesin_id, nama_mesin</span>
                    </p>
                </div>
            </div>

            {{-- Search --}}
            <div class="mb-4">
                <form action="{{ route('mesin.index') }}" method="GET" class="flex gap-2">
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
                            placeholder="Cari berdasarkan ID Mesin atau Nama Mesin...">
                    </div>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150">
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('mesin.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            No
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">
                                            ID Mesin
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">
                                            Nama Mesin
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-right whitespace-nowrap">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $data->firstItem() + $loop->index }}
                                            </td>

                                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $item->mesin_id }}
                                            </td>

                                            <td class="px-4 py-3 text-gray-700">
                                                {{ $item->nama_mesin }}
                                            </td>

                                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                                <a href="{{ route('mesin.show', $item->id) }}"
                                                    class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                                    View Details
                                                </a>

                                                <button type="button"
                                                    onclick="confirmDelete({{ $item->id }}, '{{ $item->mesin_id }}')"
                                                    class="rounded bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-100 transition">
                                                    Delete
                                                </button>

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
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 italic">
                                                Belum ada data mesin.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-4 px-4 py-3 border-t border-gray-100">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif

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
