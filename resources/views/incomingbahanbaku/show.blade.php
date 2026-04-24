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
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-4">
                            {{-- <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $inspeksi_wm->nomor_inspeksi }}</dd>
                            </div> --}}
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No PO</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingbahanbaku->no_po }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No SJ</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingbahanbaku->no_sj }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Jml Koil</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingbahanbaku->jml_koil }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">D Kawat</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingbahanbaku->d_kawat }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Toleransi</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingbahanbaku->tol }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Jenis Kawat</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $incomingbahanbaku->jenis_kawat }}
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi Icoming Bahan Baku</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No. Material</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Operator</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">D. Kawat Act</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Selisih Diagonal</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">P Produk</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">L Produk</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">P Mesh</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">L Mesh</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Torsi Strength</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Dimensi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Visual</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                </tr>
                            </thead>
                            {{-- <tbody class="divide-y divide-gray-200">
                                @forelse ($inspeksi_wm->inspeksiWmWip as $wip)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $wip->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $wip->no_material }}</td>
                                        <td class="px-4 py-3">{{ $wip->nama_operator }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->d_kawat_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->selisih_diagonal }}
                                        </td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->p_product_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->l_product_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->p_mesh_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->l_mesh_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->torsi_strength }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->status_dimensi }}
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->visual }}
                                        </td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-400 italic">Belum
                                            ada
                                            data WIP untuk inspeksi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody> --}}
                        </table>
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
    </script>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus seluruh record?',
                text: "Semua data WIP dan FG terkait " + name + " akan ikut terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Hapus Semua!',
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
