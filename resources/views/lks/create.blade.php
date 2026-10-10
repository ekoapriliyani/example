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
                                        <th class="px-4 py-3 text-left font-semibold text-gray-900">Hasil Inspeksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" id="lots-body">
                                    <tr>
                                        <td colspan="9" class="px-4 py-6 text-center text-gray-400 italic" id="empty-lots">
                                            Pilih supplier dan bulan terlebih dahulu untuk melihat lot number.
                                        </td>
                                    </tr>
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

    {{-- Modal Gambar Lampiran --}}
    <div id="lks-image-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">
                Gambar Lampiran: <span class="text-indigo-600" id="lks-modal-title">-</span>
            </h3>
            <div id="lks-modal-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
            <div class="mt-6 text-right">
                <button type="button" id="lks-modal-close"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-medium transition">Tutup</button>
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

        const STORAGE_BASE = '{{ asset('storage') }}';
        const COLSPAN = 9;

        // Data lot awal dari server (render tanpa fetch)
        const initialLots = @json($availableLots);

        const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'webp'];

        // Escape teks untuk ditampilkan sebagai konten HTML
        function esc(value) {
            if (value === null || value === undefined || value === '') return '-';
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        // Escape string JSON untuk dipakai di dalam atribut HTML
        function jsonAttr(obj) {
            return JSON.stringify(obj ?? null)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function storageUrl(path) {
            return STORAGE_BASE + '/' + String(path).replace(/^\/+/, '');
        }

        function statusBadge(status, okValue) {
            const isOk = status === okValue;
            const cls = isOk ? 'text-green-800 bg-green-200' : 'text-yellow-800 bg-yellow-200';
            return `<span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full ${cls}">${esc(status ?? '-')}</span>`;
        }

        function field(label, value, extraClass = '') {
            return `
                <div>
                    <span class="block text-xs text-gray-500">${label}</span>
                    <span class="font-semibold text-gray-800 ${extraClass}">${esc(value)}</span>
                </div>`;
        }

        // Isi sub-row "Hasil Inspeksi" sesuai sumber data
        function hasilHtml(lot) {
            const files = Array.isArray(lot.files) ? lot.files : [];
            let fields = '';

            if (lot.sumber === 'inspeksi') {
                fields = `
                    <div class="flex flex-wrap gap-x-8 gap-y-3 items-end">
                        ${field('D1', lot.d1)}
                        ${field('D2', lot.d2)}
                        ${field('D3', lot.d3)}
                        ${field('Rata-rata', lot.rata_rata, 'text-indigo-600')}
                        <div>
                            <span class="block text-xs text-gray-500">Dimensi</span>
                            ${statusBadge(lot.dimensi, 'OK')}
                        </div>
                        <div>
                            <span class="block text-xs text-gray-500">Visual</span>
                            ${statusBadge(lot.visual, 'OK')}
                        </div>
                    </div>`;
            } else if (lot.sumber === 'mechanical') {
                fields = `
                    <div class="flex flex-wrap gap-x-8 gap-y-3 items-end">
                        ${field('Hasil Tensile', lot.hasil_tensile != null ? lot.hasil_tensile + ' Mpa' : null)}
                        ${field('Coating Weight', lot.hasil_coatingweight != null ? lot.hasil_coatingweight + ' g/m²' : null)}
                        <div>
                            <span class="block text-xs text-gray-500">Hasil Lilit</span>
                            ${statusBadge(lot.hasil_lilit, 'OK')}
                        </div>
                        ${field('Hasil Puntir', lot.hasil_puntir != null ? lot.hasil_puntir + ' kali' : null)}
                    </div>`;
            } else {
                fields = '<span class="text-xs text-gray-400 italic">Data hasil tidak tersedia.</span>';
            }

            const gambar = files.length
                ? `<button type="button"
                        class="btn-gambar inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition"
                        data-title="${esc(lot.lot_number)}" data-files="${jsonAttr(files)}">
                        Gambar (${files.length})
                    </button>`
                : '<span class="text-xs text-gray-400 italic">Tidak ada gambar.</span>';

            return `
                <div class="flex flex-wrap items-start justify-between gap-4 rounded-lg bg-white border border-gray-200 p-4 shadow-sm">
                    <div>
                        <span class="block mb-2 text-xs font-bold uppercase tracking-wide text-gray-500">
                            Hasil ${lot.sumber === 'mechanical' ? 'Mechanical Test' : 'Inspeksi Incoming'}
                        </span>
                        ${fields}
                    </div>
                    <div class="text-right">${gambar}</div>
                </div>`;
        }

        function rowHtml(lot, idx) {
            const sumberCls = lot.sumber === 'inspeksi'
                ? 'text-blue-800 bg-blue-200'
                : 'text-green-800 bg-green-200';
            const statusCls = lot.status === 'REJECT'
                ? 'text-red-800 bg-red-200'
                : 'text-yellow-800 bg-yellow-200';
            const sumberLabel = lot.sumber
                ? lot.sumber.charAt(0).toUpperCase() + lot.sumber.slice(1)
                : '-';
            const detailId = `detail-row-${idx}`;

            return `
                        <tr class="hover:bg-gray-50 lot-row">
                            <td class="px-3 py-3 text-center">
                                <input type="checkbox" name="lots[]"
                                    value="${jsonAttr(lot)}"
                                    class="lot-checkbox rounded">
                            </td>
                            <td class="px-4 py-3 font-semibold text-indigo-600">${esc(lot.lot_number)}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full ${sumberCls}">
                                    ${esc(sumberLabel)}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium">${esc(lot.no_koil)}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full ${statusCls}">
                                    ${esc(lot.status)}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">${esc(lot.description1)}</td>
                            <td class="px-4 py-3 text-gray-600">${esc(lot.description2)}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">${esc(lot.tanggal_inspeksi)}</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="btn-detail text-xs font-semibold text-indigo-600 hover:underline"
                                    data-target="${detailId}">Lihat Hasil ▾</button>
                            </td>
                        </tr>
                        <tr id="${detailId}" class="detail-row hidden bg-gray-50">
                            <td colspan="${COLSPAN}" class="px-4 py-3">
                                ${hasilHtml(lot)}
                            </td>
                        </tr>`;
        }

        function stateRow(message, cls) {
            const spin = cls === 'text-indigo-500'
                ? `<svg class="animate-spin h-5 w-5 mx-auto text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>`
                : '';

            return `
                    <tr>
                        <td colspan="${COLSPAN}" class="px-4 py-6 text-center ${cls}">
                            ${spin}
                            ${message}
                        </td>
                    </tr>`;
        }

        function renderLots(lots) {
            if (!lots || lots.length === 0) {
                lotsBody.innerHTML = stateRow(
                    'Tidak ada lot number NG/REJECT untuk supplier dan bulan ini.',
                    'text-gray-400 italic'
                );
            } else {
                lotsBody.innerHTML = lots.map((lot, idx) => rowHtml(lot, idx)).join('');
            }

            if (checkAll) checkAll.checked = false;
            if (btnCheckAll) btnCheckAll.textContent = 'Centang Semua';
        }

        function fetchLots() {
            const supplierId = supplierSelect.value;
            const bulan = bulanInput.value;

            if (!supplierId || !bulan) {
                lotsBody.innerHTML = stateRow(
                    'Pilih supplier dan bulan terlebih dahulu untuk melihat lot number.',
                    'text-gray-400 italic'
                );
                return;
            }

            lotsBody.innerHTML = stateRow('Memuat data lot...', 'text-indigo-500');

            fetch(`{{ route('lks.api.lots', [], false) }}?supplier_id=${supplierId}&bulan=${bulan}`, {
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
                    renderLots(lots);
                })
                .catch(err => {
                    console.error('LKS fetch error:', err);
                    lotsBody.innerHTML = stateRow(
                        `Gagal memuat data: ${esc(err.message)}. Silakan coba lagi.`,
                        'text-red-500'
                    );
                });
        }

        // Render data lot awal dari server (sudah terpilih supplier & bulan)
        if (supplierSelect.value && bulanInput.value) {
            renderLots(initialLots);
        }

        supplierSelect.addEventListener('change', fetchLots);
        bulanInput.addEventListener('change', fetchLots);

        // Delegasi event: toggle detail & buka modal gambar
        lotsBody.addEventListener('click', function(e) {
            const btnDetail = e.target.closest('.btn-detail');
            if (btnDetail) {
                const row = document.getElementById(btnDetail.dataset.target);
                if (row) {
                    const hidden = row.classList.toggle('hidden');
                    btnDetail.textContent = hidden ? 'Lihat Hasil ▾' : 'Sembunyikan ▴';
                }
                return;
            }

            const btnGambar = e.target.closest('.btn-gambar');
            if (btnGambar) {
                let files = [];
                try {
                    files = JSON.parse(btnGambar.dataset.files || '[]');
                } catch (err) {
                    console.error('Gagal membaca daftar gambar:', err);
                }
                openImageModal(files, btnGambar.dataset.title);
            }
        });

        // Modal gambar
        const imageModal = document.getElementById('lks-image-modal');
        const modalTitle = document.getElementById('lks-modal-title');
        const modalGrid = document.getElementById('lks-modal-grid');

        function openImageModal(files, title) {
            modalTitle.textContent = title || '-';

            if (!files || files.length === 0) {
                modalGrid.innerHTML = '<p class="text-gray-400 italic col-span-2">Tidak ada file yang diupload.</p>';
            } else {
                modalGrid.innerHTML = files.map(file => {
                    // Dukung format lama: path tunggal atau array berisi path
                    const path = Array.isArray(file) ? (file[0] ?? '') : file;
                    if (!path) return '';

                    const ext = (String(path).split('.').pop() || '').toLowerCase();
                    const url = esc(storageUrl(path));

                    if (IMAGE_EXT.includes(ext)) {
                        return `<img src="${url}" alt="Lampiran"
                            class="w-full h-64 object-contain rounded border shadow-sm" />`;
                    }

                    return `<a href="${url}" target="_blank"
                        class="flex items-center justify-center p-4 border rounded bg-gray-50 text-indigo-600 hover:underline font-medium">
                        Lihat File (${esc(ext.toUpperCase() || 'DOC')})
                    </a>`;
                }).join('');
            }

            imageModal.classList.remove('hidden');
        }

        function closeImageModal() {
            imageModal.classList.add('hidden');
            modalGrid.innerHTML = '';
        }

        document.getElementById('lks-modal-close').addEventListener('click', closeImageModal);
        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal) closeImageModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !imageModal.classList.contains('hidden')) closeImageModal();
        });

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
