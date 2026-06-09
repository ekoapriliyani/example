<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Inspeksi Incoming PVC / HDPE') }}
            </h2>

            <a href="{{ route('incomingpvchdpe.create') }}"
                class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Inspeksi PVC / HDPE
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-6">
                <form action="{{ route('incomingpvchdpe.index') }}" method="GET" class="flex gap-2">
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
                            placeholder="Cari nomor inspeksi, supplier atau tanggal...">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('incomingpvchdpe.index') }}"
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
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left w-32">Aksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Tanggal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Nomor Inspeksi</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Supplier</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No PO</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">No SJ</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Certificate</th>
                                        <th class="px-4 py-3 font-semibold text-gray-900 text-left">Gambar</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($data as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-medium text-gray-900">
                                                {{ $loop->iteration + ($data->firstItem() - 1) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex items-center justify-start gap-2">
                                                    <a href="{{ route('incomingpvchdpe.show', $item->id) }}"
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition"
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

                                                    <a href="{{ route('incomingpvchdpe.edit', $item->id) }}"
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded bg-yellow-50 text-yellow-700 hover:bg-yellow-100 transition"
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
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded bg-red-50 text-red-700 hover:bg-red-100 transition"
                                                        title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                        </svg>
                                                    </button>
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('incomingpvchdpe.destroy', $item->id) }}"
                                                        method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>

                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->tanggal }}</td>
                                            <td class="px-4 py-3 font-semibold text-gray-900">
                                                {{ $item->nomor_inspeksi }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $item->supplier->nama ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-700">{{ $item->no_po }}</td>
                                            <td class="px-4 py-3 text-gray-700">{{ $item->no_sj }}</td>
                                            <td class="px-4 py-3 text-gray-600">{{ $item->certificate }}</td>
                                            <td class="px-4 py-3">
                                                <button type="button"
                                                    class="text-sm text-indigo-600 font-semibold hover:underline"
                                                    onclick="toggleImage({{ $item->id }})">
                                                    Lihat Gambar
                                                </button>
                                            </td>

                                            <div id="image-{{ $item->id }}"
                                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                                                <div
                                                    class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">File Lampiran
                                                        Inspeksi: <span
                                                            class="text-indigo-600">{{ $item->nomor_inspeksi }}</span>
                                                    </h3>

                                                    @if ($item->files && count($item->files))
                                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                                            @foreach ($item->files as $file)
                                                                @php
                                                                    $actualFile = is_array($file)
                                                                        ? $file[0] ?? ''
                                                                        : $file;
                                                                    $ext = !empty($actualFile)
                                                                        ? pathinfo(
                                                                            (string) $actualFile,
                                                                            PATHINFO_EXTENSION,
                                                                        )
                                                                        : '';
                                                                @endphp

                                                                @if (!empty($actualFile))
                                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                                        <img src="{{ asset('storage/' . $actualFile) }}"
                                                                            alt="File Image"
                                                                            class="w-full h-40 object-cover rounded border cursor-pointer hover:opacity-90 transition"
                                                                            onclick="previewImage('{{ asset('storage/' . $actualFile) }}')" />
                                                                    @else
                                                                        <a href="{{ asset('storage/' . $actualFile) }}"
                                                                            target="_blank"
                                                                            class="flex items-center justify-center p-4 border rounded bg-gray-50 text-blue-600 hover:underline font-medium text-sm">
                                                                            Lihat Dokumen
                                                                            ({{ strtoupper($ext) ?: 'FILE' }})
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-gray-400 italic">Tidak ada file yang diupload.
                                                        </p>
                                                    @endif

                                                    <div class="mt-6 text-right">
                                                        <button onclick="toggleImage({{ $item->id }})"
                                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium transition">
                                                            Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-4 py-8 text-center text-gray-500 italic">
                                                Belum ada data rekaman inspeksi PVC / HDPE.
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
        // Notifikasi Toast Flash Success Handler
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

        // Interceptor Konfirmasi Hapus SweetAlert2
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus data inspeksi?',
                text: "Seluruh record nomor " + name + " akan dihapus permanen dari sistem!",
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
    <script>
        // Toggler Tampilan Open-Close Modal Ringkas
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

        // Tampilan Zoom Layar Penuh Gambar Lampiran saat Diklik
        function previewImage(src) {
            const preview = document.createElement('div');
            preview.className = "fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4";
            preview.innerHTML = `
                <div class="relative max-w-full max-h-full">
                    <img src="${src}" class="max-h-[90vh] max-w-[90vw] rounded shadow-2xl object-contain" />
                    <button onclick="this.parentElement.parentElement.remove()" 
                        class="absolute -top-10 right-0 bg-white text-gray-800 font-bold px-3 py-1 rounded shadow hover:bg-gray-100 transition">✕ Close</button>
                </div>
            `;
            document.body.appendChild(preview);
        }
    </script>
</x-app-layout>
