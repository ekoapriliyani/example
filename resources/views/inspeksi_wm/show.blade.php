<x-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Tombol tambah data -->
        <div class="mb-6 flex gap-3">
            <a href="{{ route('inspeksi_wm.wip', $inspeksi_wm->id) }}"
                class="py-2 px-4 rounded bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                Tambahkan WIP
            </a>
            <a href="{{ route('inspeksi_wm.fg', $inspeksi_wm->id) }}"
                class="py-2 px-4 rounded bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition">
                Tambahkan FG
            </a>
        </div>

        <!-- Header detail inspeksi -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="p-6 sm:p-8">
                <dl class="-my-3 divide-y divide-gray-100 text-sm">
                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                        <dt class="font-semibold text-gray-900">Nomor Inspeksi</dt>
                        <dd class="text-gray-700 sm:col-span-2">
                            <span
                                class="inline-flex items-center justify-center rounded-full bg-teal-100 px-2.5 py-0.5 text-teal-700">
                                {{ $inspeksi_wm->nomor_inspeksi }}
                            </span>
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 gap-1 py-4 sm:grid-cols-3 sm:gap-4">
                        <dt class="font-semibold text-gray-900">Tanggal</dt>
                        <dd class="text-gray-700 text-base sm:col-span-2">
                            {{ $inspeksi_wm->tanggal }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Tombol hapus -->
        <div class="mt-8 rounded-lg border border-red-100 bg-red-50 p-4">
            <form id="delete-form-{{ $inspeksi_wm->id }}" action="{{ route('inspeksi_wm.destroy', $inspeksi_wm->id) }}"
                method="POST" class="flex justify-end">
                @csrf
                @method('DELETE')
                <button type="button"
                    onclick="confirmDelete({{ $inspeksi_wm->id }}, '{{ $inspeksi_wm->nomor_inspeksi }}')"
                    class="rounded bg-red-600 px-4 py-2 text-xs font-bold text-white hover:bg-red-700 transition shadow-sm">
                    Hapus
                </button>
            </form>
        </div>

        <!-- Tabel hasil WIP -->
        <div class="mt-8">
            <h3 class="font-bold mb-2">Hasil Inspeksi WIP Wiremesh</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">No</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Inspektor</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">No Material</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($inspeksi_wm->inspeksiWmWip as $wip)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $wip->user_id }}</td>
                                <td class="px-4 py-2">{{ $wip->no_material }}</td>
                                <td class="px-4 py-2">{{ $wip->nama_operator }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">
                                    Belum ada data WIP.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel hasil FG -->
        <div class="mt-8">
            <h3 class="font-bold mb-2">Data FG</h3>
            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left">Batch</th>
                        <th class="px-3 py-2 text-left">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inspeksi_wm->inspeksiWmFg as $fg)
                        <tr class="border-t">
                            <td class="px-3 py-2">{{ $fg->batch_number }}</td>
                            <td class="px-3 py-2">{{ $fg->qty }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-3 py-4 text-center text-gray-500 italic">
                                Belum ada data FG.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus inspeksi?',
                text: "Inspeksi " + name + " akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

    <x-slot:footer>
        <strong>Inspeksi WM Detail Page</strong>
    </x-slot:footer>
</x-layout>
