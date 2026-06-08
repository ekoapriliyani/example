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
                            placeholder="Cari nomor inspeksi, tanggal, PO, supplier...">
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
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Aksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tanggal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Nomor Inspeksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Supplier</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No PO</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No SJ</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jml Koil</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">D Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tol Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Jenis Kawat</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Certificate</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-center">Files</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Created At</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration + ($data->firstItem() - 1) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex justify-start items-center gap-2">
                                                    <a href="{{ route('incomingbahanbaku.show', $item->id) }}"
                                                        class="flex items-center justify-center rounded bg-indigo-50 p-2 text-indigo-700 hover:bg-indigo-100 transition"
                                                        title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('incomingbahanbaku.edit', $item->id) }}"
                                                        class="flex items-center justify-center rounded bg-yellow-50 p-2 text-yellow-700 hover:bg-yellow-100 transition"
                                                        title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                        </svg>
                                                    </a>
                                                    <button type="button"
                                                        onclick="confirmDelete({{ $item->id }}, '{{ $item->nomor_inspeksi }}')"
                                                        class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 hover:bg-red-100 transition"
                                                        title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                        </svg>
                                                    </button>
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('incomingbahanbaku.destroy', $item->id) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->nomor_inspeksi }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $item->supplier->nama ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->no_po }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->no_sj }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->jml_koil }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->d_kawat }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->tol }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->jenis_kawat }}
                                            </td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->certificate }}
                                            </td>
                                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                                @if ($item->files && count($item->files))
                                                    <button type="button"
                                                        onclick='openFileModal(@json($item->files))'
                                                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12H9m12 0A9 9 0 1112 3a9 9 0 019 9z" />
                                                        </svg>
                                                        Lihat File ({{ count($item->files) }})
                                                    </button>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">No files</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-xs text-gray-500">
                                                {{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="px-4 py-8 text-center text-gray-500 italic">
                                                Belum ada data inspeksi bahan baku.
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

    <div id="fileModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-6">
        <div class="relative max-h-[90vh] w-full max-w-5xl overflow-auto rounded-2xl bg-white shadow-xl">
            <div class="sticky top-0 flex items-center justify-between border-b bg-white px-6 py-4 z-10">
                <h3 class="text-lg font-semibold text-gray-800">Preview File</h3>
                <button onclick="closeFileModal()"
                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 text-lg font-bold">✕</button>
            </div>
            <div id="filePreviewContainer" class="space-y-6 p-6"></div>
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

        // Fungsi Open Modal File
        function openFileModal(files) {
            let modal = document.getElementById('fileModal');
            let container = document.getElementById('filePreviewContainer');
            container.innerHTML = '';

            files.forEach(file => {
                let url = '/storage/' + file;
                let ext = file.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    container.innerHTML += `
                        <div class="flex justify-center">
                            <img src="${url}" class="max-w-full rounded-xl border shadow-sm">
                        </div>`;
                } else if (ext === 'pdf') {
                    container.innerHTML += `
                        <iframe src="${url}" class="h-[650px] w-full rounded-xl border"></iframe>`;
                } else {
                    container.innerHTML += `
                        <div class="rounded-lg border bg-gray-50 p-4 flex justify-between items-center">
                            <span class="text-sm text-gray-600 font-medium">${file.split('/').pop()}</span>
                            <a href="${url}" target="_blank" class="text-indigo-600 font-semibold hover:underline text-sm">
                                Download File
                            </a>
                        </div>`;
                }
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Fungsi Close Modal
        function closeFileModal() {
            let modal = document.getElementById('fileModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
