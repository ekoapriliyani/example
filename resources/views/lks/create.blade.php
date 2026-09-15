<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Buat LKS Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('lks.store') }}" method="POST" class="space-y-6" id="lks-form">
                    @csrf

                    {{-- Pilih Supplier & Bulan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier <span class="text-red-600">*</span></label>
                            <select name="supplier_id" id="supplier_id" required
                                class="w-full border rounded px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', request('supplier_id')) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }} ({{ $supplier->supplier_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bulan <span class="text-red-600">*</span></label>
                            <input type="month" name="bulan" id="bulan" required
                                value="{{ old('bulan', $selectedBulan) }}"
                                class="w-full border rounded px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('bulan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full border rounded px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Keterangan umum LKS (opsional)">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Tabel Lot Number --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-bold text-gray-700">
                                Lot Number NG / REJECT
                                <span class="text-red-600">*</span>
                            </label>
                            <button type="button" id="btn-check-all"
                                class="text-xs text-indigo-600 hover:underline font-semibold">Centang Semua</button>
                        </div>

                        @error('lots')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror

                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-3 text-center w-10">
                                            <input type="checkbox" id="check-all" class="rounded">
                                        </th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Lot Number</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Sumber</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">No Koil</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Status</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Description 1</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Description 2</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" id="lots-body">
                                    @if ($availableLots->isEmpty())
                                        <tr>
                                            <td colspan="8" class="px-4 py-6 text-center text-gray-400 italic" id="empty-lots">
                                                Pilih supplier dan bulan terlebih dahulu untuk melihat lot number.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($availableLots as $idx => $lot)
                                            <tr class="hover:bg-gray-50 lot-row">
                                                <td class="px-3 py-3 text-center">
                                                    <input type="checkbox" name="lots[]"
                                                        value='@json($lot)'
                                                        class="lot-checkbox rounded">
                                                </td>
                                                <td class="px-4 py-3 font-semibold text-indigo-600">{{ $lot['lot_number'] }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                                        {{ $lot['sumber'] === 'inspeksi' ? 'text-blue-800 bg-blue-200' : 'text-green-800 bg-green-200' }}">
                                                        {{ ucfirst($lot['sumber']) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 font-medium">{{ $lot['no_koil'] ?? '-' }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                                        {{ $lot['status'] === 'REJECT' ? 'text-red-800 bg-red-200' : 'text-yellow-800 bg-yellow-200' }}">
                                                        {{ $lot['status'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-gray-600">{{ $lot['description1'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-gray-600">{{ $lot['description2'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-xs text-gray-500">{{ $lot['tanggal_inspeksi'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('lks.index') }}"
                            class="px-4 py-2 bg-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-400 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition">
                            Simpan LKS
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: true,
            });
        @endif

        const supplierSelect = document.getElementById('supplier_id');
        const bulanInput = document.getElementById('bulan');
        const lotsBody = document.getElementById('lots-body');
        const checkAll = document.getElementById('check-all');
        const btnCheckAll = document.getElementById('btn-check-all');

        function fetchLots() {
            const supplierId = supplierSelect.value;
            const bulan = bulanInput.value;

            if (!supplierId || !bulan) {
                lotsBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                            Pilih supplier dan bulan terlebih dahulu untuk melihat lot number.
                        </td>
                    </tr>`;
                return;
            }

            lotsBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-gray-400">
                        <svg class="animate-spin h-5 w-5 mx-auto text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Memuat data lot...
                    </td>
                </tr>`;

            fetch(`{{ route('lks.api.lots') }}?supplier_id=${supplierId}&bulan=${bulan}`, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (res.redirected) {
                        window.location.href = res.url;
                        return;
                    }
                    if (!res.ok) {
                        throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                    }
                    return res.json();
                })
                .then(lots => {
                    if (!lots) return; // redirected
                    if (lots.length === 0) {
                        lotsBody.innerHTML = `
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-400 italic">
                                    Tidak ada lot number NG/REJECT untuk supplier dan bulan ini.
                                </td>
                            </tr>`;
                        return;
                    }

                    lotsBody.innerHTML = lots.map((lot, idx) => `
                        <tr class="hover:bg-gray-50 lot-row">
                            <td class="px-3 py-3 text-center">
                                <input type="checkbox" name="lots[]"
                                    value='${JSON.stringify(lot)}'
                                    class="lot-checkbox rounded">
                            </td>
                            <td class="px-4 py-3 font-semibold text-indigo-600">${lot.lot_number}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                    ${lot.sumber === 'inspeksi' ? 'text-blue-800 bg-blue-200' : 'text-green-800 bg-green-200'}">
                                    ${lot.sumber.charAt(0).toUpperCase() + lot.sumber.slice(1)}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium">${lot.no_koil ?? '-'}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                    ${lot.status === 'REJECT' ? 'text-red-800 bg-red-200' : 'text-yellow-800 bg-yellow-200'}">
                                    ${lot.status}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">${lot.description1 ?? '-'}</td>
                            <td class="px-4 py-3 text-gray-600">${lot.description2 ?? '-'}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">${lot.tanggal_inspeksi}</td>
                        </tr>
                    `).join('');

                    if (checkAll) checkAll.checked = false;
                })
                .catch(err => {
                    console.error('LKS fetch error:', err);
                    lotsBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-red-500">
                                Gagal memuat data: ${err.message}. Silakan coba lagi.
                            </td>
                        </tr>`;
                });
        }

        supplierSelect.addEventListener('change', fetchLots);
        bulanInput.addEventListener('change', fetchLots);

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('.lot-checkbox').forEach(cb => {
                    cb.checked = checkAll.checked;
                });
            });
        }

        if (btnCheckAll) {
            btnCheckAll.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.lot-checkbox');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                checkboxes.forEach(cb => cb.checked = !allChecked);
                if (checkAll) checkAll.checked = !allChecked;
                btnCheckAll.textContent = allChecked ? 'Centang Semua' : 'Batal Centang';
            });
        }

        // Validasi sebelum submit
        document.getElementById('lks-form').addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.lot-checkbox:checked');
            if (checked.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Pilih minimal 1 lot number untuk dimasukkan ke LKS.',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
</x-app-layout>
