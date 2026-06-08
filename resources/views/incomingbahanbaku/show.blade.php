<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inspeksi Incoming') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('incomingbahanbaku.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    Kembali
                </a>
                <a href="{{ route('incomingbahanbaku.inspeksi', $incomingbahanbaku->id) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Inspeksi
                </a>
                <a href="{{ route('incomingbahanbaku.mechanicaltest', $incomingbahanbaku->id) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800 transition shadow-sm">
                    Mechanical Test
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
                                <dd class="text-lg font-bold text-indigo-600">{{ $incomingbahanbaku->nomor_inspeksi }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->tanggal }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Supplier</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->supplier->nama }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No PO</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->no_po }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No SJ</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->no_sj }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Jml Koil</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->jml_koil }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">D Kawat</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->d_kawat }} mm
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Toleransi</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->tol }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Jenis Kawat</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $incomingbahanbaku->jenis_kawat }}
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi Incoming Bahan Baku</h3>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No Koil</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D3</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Rata Rata</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Dimensi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Visual</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($incomingbahanbaku->incomingbahanbakuinspeksi as $inc)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('incomingbahanbaku.inspeksi.edit', ['incomingbahanbaku' => $incomingbahanbaku->id, 'inspeksi' => $inc->id]) }}"
                                                    class="flex items-center justify-center rounded bg-yellow-50 p-2 text-yellow-700 hover:bg-yellow-100 transition">
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
                                                <form
                                                    action="{{ route('incomingbahanbaku.inspeksi.destroy', $inc->id) }}"
                                                    method="POST" class="form-delete inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 hover:bg-red-100 transition">
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
                                        <td class="px-4 py-3 font-semibold">{{ $inc->no_koil }}</td>
                                        <td class="px-4 py-3">{{ $inc->d1 }}</td>
                                        <td class="px-4 py-3">{{ $inc->d2 }}</td>
                                        <td class="px-4 py-3">{{ $inc->d3 }}</td>
                                        <td class="px-4 py-3 font-medium text-indigo-600">{{ $inc->rata_rata }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $inc->dimensi === 'OK' ? 'text-green-800 bg-green-200' : 'text-yellow-800 bg-yellow-200' }}">
                                                {{ $inc->dimensi }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $inc->visual === 'OK' ? 'text-green-800 bg-green-200' : 'text-yellow-800 bg-yellow-200' }}">
                                                {{ $inc->visual }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $inc->description1 }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $inc->description2 }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                class="text-sm text-indigo-600 font-semibold hover:underline"
                                                onclick="toggleImage({{ $inc->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3 text-center text-xs text-gray-500">{{ $inc->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="px-4 py-8 text-center text-gray-400 italic">Belum
                                            ada data Inspeksi Incoming Bahan Baku.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-green-100 rounded-lg text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Hasil Mechanical Test</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No Koil</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Hasil Tensile</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Hasil Coating Weight</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Hasil Lilit</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Hasil Puntir</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($incomingbahanbaku->mechanicalTests as $test)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('incomingbahanbaku.mechanical_test.edit', ['incomingbahanbaku' => $incomingbahanbaku->id, 'mechanicalTest' => $test->id]) }}"
                                                    class="flex items-center justify-center rounded bg-yellow-50 p-2 text-yellow-700 hover:bg-yellow-100 transition">
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
                                                <form
                                                    action="{{ route('incomingbahanbaku.mechanical_test.destroy', $test->id) }}"
                                                    method="POST" class="form-delete inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center justify-center rounded bg-red-50 p-2 text-red-700 hover:bg-red-100 transition">
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
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $test->status === 'OK' ? 'text-green-800 bg-green-200' : 'text-yellow-800 bg-yellow-200' }}">
                                                {{ $test->status ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $test->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $test->nomor_koil }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $test->hasil_tensile }} Mpa</td>
                                        <td class="px-4 py-3">{{ $test->hasil_coatingweight }} g/m<sup>2</sup></td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $test->hasil_lilit === 'OK' ? 'text-green-800 bg-green-200' : 'text-red-800 bg-red-200' }}">
                                                {{ $test->hasil_lilit }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $test->hasil_puntir }} kali</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $test->description1 }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $test->description2 }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                class="text-sm text-indigo-600 font-semibold hover:underline"
                                                onclick="toggleImage2({{ $test->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3 text-center text-xs text-gray-500">
                                            {{ $test->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="px-4 py-8 text-center text-gray-400 italic">Belum
                                            ada data Mechanical Test.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @foreach ($incomingbahanbaku->incomingbahanbakuinspeksi as $inc)
        <div id="image-{{ $inc->id }}"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Gambar Incoming No Koil: <span
                        class="text-indigo-600">{{ $inc->no_koil }}</span></h3>
                @if ($inc->files)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($inc->files as $file)
                            @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                <img src="{{ asset('storage/' . $file) }}" alt="Incoming Image"
                                    class="w-full h-64 object-contain rounded border shadow-sm" />
                            @else
                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                    class="flex items-center justify-center p-4 border rounded bg-gray-50 text-indigo-600 hover:underline font-medium">
                                    Lihat File ({{ strtoupper($ext) }})
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 italic">Tidak ada file yang diupload.</p>
                @endif
                <div class="mt-6 text-right">
                    <button onclick="toggleImage({{ $inc->id }})"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium transition">Tutup</button>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($incomingbahanbaku->mechanicalTests as $test)
        <div id="image2-{{ $test->id }}"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Gambar Mechanical Test No Koil: <span
                        class="text-green-700">{{ $test->nomor_koil }}</span></h3>
                @if ($test->files)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($test->files as $file)
                            @php
                                $actualFile = is_array($file) ? $file[0] ?? '' : $file;
                                $ext = !empty($actualFile) ? pathinfo((string) $actualFile, PATHINFO_EXTENSION) : '';
                            @endphp

                            @if (!empty($actualFile))
                                @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                    <img src="{{ asset('storage/' . $actualFile) }}" alt="Mechanical Test Image"
                                        class="w-full h-64 object-contain rounded border shadow-sm" />
                                @else
                                    <a href="{{ asset('storage/' . $actualFile) }}" target="_blank"
                                        class="flex items-center justify-center p-4 border rounded bg-gray-50 text-green-700 hover:underline font-medium">
                                        Lihat File ({{ strtoupper($ext) ?: 'DOC' }})
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
                <div class="mt-6 text-right">
                    <button onclick="toggleImage2({{ $test->id }})"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium transition">Tutup</button>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            if (modal) modal.classList.toggle('hidden');
        }

        function toggleImage2(id) {
            const modal = document.getElementById('image2-' + id);
            if (modal) modal.classList.toggle('hidden');
        }
    </script>

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

        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus data?',
                    text: "Data pemeriksaan item ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
