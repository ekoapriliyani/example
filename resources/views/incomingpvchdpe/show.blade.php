<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inspeksi Incoming') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('incomingpvchdpe.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    Kembali
                </a>
                <a href="{{ route('incomingpvchdpe.inspeksi', $incomingpvchdpe->id) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Inspeksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <dl class="grid grid-cols-3 gap-x-8 gap-y-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $incomingpvchdpe->nomor_inspeksi }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingpvchdpe->tanggal }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Supplier</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingpvchdpe->supplier->nama }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No PO</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingpvchdpe->no_po }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No SJ</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingpvchdpe->no_sj }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Certificate</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingpvchdpe->certificate }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi Incoming PVC / HDPE</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900 w-16">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center w-28">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Warna</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Keterangan</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($incomingpvchdpe->incomingpvchdpeinspeksi as $inc)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>

                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('incomingpvchdpe.inspeksi.edit', ['incomingpvchdpe' => $incomingpvchdpe->id, 'inspeksi' => $inc->id]) }}"
                                                    class="flex items-center justify-center rounded bg-yellow-50 p-2 text-yellow-700 hover:bg-yellow-100 transition"
                                                    title="Edit Item">
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

                                                <form id="delete-form-{{ $inc->id }}"
                                                    action="{{ route('incomingpvchdpe.inspeksi.destroy', $inc->id) }}"
                                                    method="POST" class="form-delete inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDeleteChild({{ $inc->id }}, '{{ $inc->warna }}')"
                                                        class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 hover:bg-red-100 transition"
                                                        title="Hapus Item">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3">{{ $inc->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $inc->warna }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $inc->status === 'OK' ? 'text-green-800 bg-green-200' : 'text-red-800 bg-red-200' }}">
                                                {{ $inc->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $inc->keterangan ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                class="text-sm text-indigo-600 font-semibold hover:underline"
                                                onclick="toggleImage({{ $inc->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3 text-center text-xs text-gray-500 bg-blue-50/30">
                                            {{ $inc->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-400 italic">Belum
                                            ada data Inspeksi Incoming PVC / HDPE.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @foreach ($incomingpvchdpe->incomingpvchdpeinspeksi as $inc)
        <div id="image-{{ $inc->id }}"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Gambar Item Warna: <span
                        class="text-indigo-600">{{ $inc->warna }}</span></h3>

                @if ($inc->files)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($inc->files as $file)
                            @php
                                // Pengaman data array bertingkat (nested array)
                                $actualFile = is_array($file) ? $file[0] ?? '' : $file;
                                $ext = !empty($actualFile) ? pathinfo((string) $actualFile, PATHINFO_EXTENSION) : '';
                            @endphp

                            @if (!empty($actualFile))
                                @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                    <img src="{{ asset('storage/' . $actualFile) }}" alt="PVC HDPE Image"
                                        class="w-full h-64 object-contain rounded border shadow-sm cursor-pointer"
                                        onclick="previewImage('{{ asset('storage/' . $actualFile) }}')" />
                                @else
                                    <a href="{{ asset('storage/' . $actualFile) }}" target="_blank"
                                        class="flex items-center justify-center p-4 border rounded bg-gray-50 text-indigo-600 hover:underline font-medium text-sm">
                                        Lihat File ({{ strtoupper($ext) }})
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 italic">Tidak ada gambar diupload.</p>
                @endif

                <div class="mt-6 text-right">
                    <button onclick="toggleImage({{ $inc->id }})"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Notifikasi Sukses Simpan / Update
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

        // Interceptor SweetAlert2 Khusus Hapus Item Inspeksi PVC HDPE Child
        function confirmDeleteChild(id, name) {
            Swal.fire({
                title: 'Hapus data item ini?',
                text: "Rekam pemeriksaan item warna " + name + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
