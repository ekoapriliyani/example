<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Produk Razor
            </h2>

            <a href="{{ route('productrazor.create') }}"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Produk Razor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-sm font-bold text-gray-700 uppercase mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Import Product Razor via Excel
                    </h3>

                    <form action="{{ route('productrazor.import') }}" method="POST" enctype="multipart/form-data"
                        class="flex items-end gap-4">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Pilih File (.xlsx /
                                .csv)</label>
                            <input type="file" name="file" accept=".xlsx, .xls, .csv" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-300 rounded-md focus:outline-none" />
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 transition ease-in-out duration-150">
                            Upload & Proses
                        </button>
                    </form>
                    <p class="mt-2 text-xs text-gray-400 font-medium">* Format kolom: <span
                            class="text-indigo-600 italic">......</span> (ID akan dibuat otomatis)</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-900 whitespace-nowrap text-left">No
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Product Razor ID
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Description</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Panjang Roll</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min Roll</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max Roll</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D Spiral</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min D Spiral
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max D Spiral
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min D Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max D Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tebal Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min Tebal Blade
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max Tebal Blade
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">P Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min P Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max P Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">L Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min L Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max L Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jarak Blade</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min Jarak Blade
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max Jarak Blade
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jml Spiral</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Min Jml Spiral
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Max Jml Spiral
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jml Klip per Spiral
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jarak antar klip
                                        </th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">L Sheetgalvanized
                                        </th>
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
                                                {{ $item->product_wm_id }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->description }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->p_roll }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_p_roll }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_p_roll }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->d_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_d_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_d_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->d_kawat }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_d_kawat }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_d_kawat }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tebal_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_tebal_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_tebal_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->p_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_p_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_p_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->l_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_l_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_l_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->jarak_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_jarak_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_jarak_blade }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->jml_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_min_jml_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->tol_max_jml_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->jml_klip_per_spiral }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->jarak_antar_klip }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 min-w-50">
                                                {{ $item->l_sheetgalvanized }}
                                            </td>
                                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                                <a href="{{ route('productrazor.show', $item->id) }}"
                                                    class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-xs font-bold text-indigo-700 hover:bg-indigo-100 transition">
                                                    View Details
                                                </a>

                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('productrazor.destroy', $item->id) }}"
                                                    method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 italic">
                                                Belum ada data produk Razor. Silakan tambah produk baru.
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
