<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Detail Informasi Produk WM') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">xxxxxx.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('productwm.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>

                <a href="{{ route('productwm.edit', $productwm->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Produk WM
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 text-gray-900">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm">
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Product WM ID</dt>
                            <dd class="text-gray-700 sm:col-span-2">
                                <span
                                    class="inline-flex items-center justify-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-indigo-700 font-medium">
                                    {{ $productwm->product_wm_id }}
                                </span>
                            </dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Jenis WM</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->jenis_wm }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Diameter Kawat</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->d_kawat }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Tol -/+ D</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->tol_d }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Panjang Product</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->p_product }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Lebar Product</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->l_product }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Panjang Mesh</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->p_mesh }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Lebar Mesh</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->l_mesh }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Tol Mesh</dt>
                            <dd class="text-gray-700 text-base sm:col-span-2">{{ $productwm->tol_mesh }}</dd>
                        </div>
                        <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                            <dt class="font-semibold text-gray-900">Terdaftar Pada</dt>
                            <dd class="text-gray-600 sm:col-span-2 italic">
                                {{ $productwm->created_at->format('d M Y, H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-200">
                <div class="p-4 bg-red-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Zona Berbahaya</h3>
                        <p class="text-xs text-red-600 mt-1">Data produk wm ini akan dihapus secara permanen dari
                            sistem.
                        </p>
                    </div>

                    <form id="delete-form-{{ $productwm->id }}"
                        action="{{ route('productwm.destroy', $productwm->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="confirmDelete({{ $productwm->id }}, '{{ $productwm->product_wm_id }}')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Hapus Produk WM
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Produk WM?',
                text: "Produk WM " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>
