<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inspeksi Sheet Galvanized') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('sheetgalvanize.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    Kembali
                </a>
                <a href="{{ route('sheetgalvanize.inspeksi', $sheetgalvanize->id) }}"
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
                        <dl class="grid grid-cols-3 gap-x-8 gap-y-4 sm:grid-cols-5">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $sheetgalvanize->nomor_inspeksi }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $sheetgalvanize->tanggal }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Supplier</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $sheetgalvanize->supplier->nama }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No PO</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $sheetgalvanize->no_po }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Certificate</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $sheetgalvanize->certificate }}
                                </dd>
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi Incoming Sheet Galvanized</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Tebal</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Coating 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Coating 2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Coating 3</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Rata-rata</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Lebar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Weight</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Visual</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($sheetgalvanize->inspeksiSheetGalvanizes as $sg)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $sg->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $sg->tebal }}</td>
                                        <td class="px-4 py-3">{{ $sg->coating1 }}</td>
                                        <td class="px-4 py-3">{{ $sg->coating2 }}</td>
                                        <td class="px-4 py-3">{{ $sg->coating3 }}</td>
                                        <td class="px-4 py-3">{{ $sg->rata_rata }}</td>
                                        <td class="px-4 py-3">{{ $sg->lebar }}</td>
                                        <td class="px-4 py-3">{{ $sg->weight }}</td>
                                        <td class="px-4 py-3">
                                            @if ($sg->visual === 'OK')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">
                                                    OK
                                                </span>
                                            @elseif($sg->visual === 'NG')
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">
                                                    NG
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleImage({{ $sg->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">
                                            {{ $sg->created_at }}
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">

                                                <!-- Edit -->
                                                <a href="{{ route('sheetgalvanize.inspeksi.edit', $sg->id) }}"
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

                                                <!-- Delete -->
                                                <button type="button"
                                                    onclick="confirmDelete({{ $sg->id }}, '{{ $sg->user->name ?? 'N/A' }}')"
                                                    class="inline-flex h-8 w-8 items-center justify-center rounded bg-red-50 text-red-700 hover:bg-red-100 transition"
                                                    title="Delete">

                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
                                                    </svg>
                                                </button>

                                            </div>

                                            <form id="delete-form-{{ $sg->id }}"
                                                action="{{ route('sheetgalvanize.inspeksi.destroy', $sg->id) }}"
                                                method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-400 italic">
                                            Belum ada data Inspeksi Incoming Sheet Galvanized.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- modal gambar inc --}}
                @foreach ($sheetgalvanize->inspeksiSheetGalvanizes as $sg)
                    <div id="image-{{ $sg->id }}"
                        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                            {{-- <h3 class="text-lg font-semibold mb-4">Gambar sg: {{ $sg->batch_number }}</h3> --}}

                            @if ($sg->files)
                                <div class="space-y-4">
                                    @foreach ($sg->files as $file)
                                        @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp

                                        @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                            <img src="{{ asset('storage/' . $file) }}" alt="sg Image"
                                                class="w-full max-h-64 object-contain rounded border" />
                                        @else
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                class="block text-blue-600 hover:underline">
                                                Lihat File ({{ strtoupper($ext) }})
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400 italic">Tidak ada gambar diupload.</p>
                            @endif

                            <div class="mt-4 text-right">
                                <button onclick="toggleImage({{ $sg->id }})"
                                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            modal.classList.toggle('hidden');
        }
    </script>

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
    </script>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus data inspeksi?',
                text: "Data inspeksi oleh " + name + " akan dihapus permanen!",
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
