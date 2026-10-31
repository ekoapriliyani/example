<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inspeksi Outgoing') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('outgoing.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    Kembali
                </a>
                <button type="button" onclick="printInspeksi()"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 002 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>

                @php
                    $isApproved = $outgoing->approval_status === 'APPROVED';
                @endphp

                {{-- Tambah Inspeksi --}}
                @if ($isApproved)
                    <button type="button" disabled
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-md bg-gray-400 px-4 py-2 text-sm font-semibold text-white opacity-60 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Inspeksi
                    </button>
                @else
                    <a href="{{ route('outgoing.inspeksi', $outgoing->id) }}"
                        class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Inspeksi
                    </a>
                @endif
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
                                <dd class="text-lg font-bold text-indigo-600">{{ $outgoing->nomor_inspeksi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->tanggal }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Shipment ID</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->shipment_id ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Sales Order</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->so ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Nomor DO</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->no_do }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Produk</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->produk }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Qty</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->qty ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Lokasi</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->lokasi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">No Kendaraan</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->no_kendaraan }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Keterangan</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $outgoing->keterangan }}</dd>
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi Outgoing</h3>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Label</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Karat</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Penyok</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Kotor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Galvanized</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Lasan</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Mesh</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">PVC</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Packing</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">QTY</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($outgoing->outgoinginspeksi as $inc)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('outgoing.inspeksi.edit', ['outgoing' => $outgoing->id, 'inspeksi' => $inc->id]) }}"
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
                                                <form action="{{ route('outgoing.inspeksi.destroy', $inc->id) }}"
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
                                        <td class="px-4 py-3">{{ $inc->label }}</td>
                                        <td class="px-4 py-3">{{ $inc->karat }}</td>
                                        <td class="px-4 py-3">{{ $inc->penyok }}</td>
                                        <td class="px-4 py-3">{{ $inc->kotor }}</td>
                                        <td class="px-4 py-3">{{ $inc->galvanized }}</td>
                                        <td class="px-4 py-3">{{ $inc->lasan }}</td>
                                        <td class="px-4 py-3">{{ $inc->mesh }}</td>
                                        <td class="px-4 py-3">{{ $inc->pvc }}</td>
                                        <td class="px-4 py-3">{{ $inc->packing }}</td>
                                        <td class="px-4 py-3">{{ $inc->qty }}</td>
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
                                            ada data Inspeksi Outgoing</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($outgoing->outgoinginspeksi as $inc)
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


    {{-- section approval --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="p-6">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <!-- Left -->
                <div class="flex items-start gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-100 to-emerald-50 text-green-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            Approval Incoming Bahan Baku
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Review data inspeksi sebelum melakukan approval.
                        </p>
                    </div>
                </div>
                <!-- Middle + Right -->
                <div class="flex items-center gap-4">
                    <!-- Status -->
                    @if ($outgoing->isApproved())
                        <span
                            class="inline-flex items-center gap-2 rounded-full border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>
                            Approved
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-2 rounded-full border border-yellow-200 bg-yellow-50 px-4 py-2 text-sm font-semibold text-yellow-700">
                            <span class="h-2.5 w-2.5 rounded-full bg-yellow-500"></span>
                            Waiting Approval
                        </span>
                    @endif
                    <!-- Button -->
                    @if (in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']))
                        <form id="approval-form-{{ $outgoing->id }}"
                            action="{{ route('outgoing.toggle', $outgoing->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('PATCH')
                        </form>
                        <button type="button"
                            onclick="confirmApproval({{ $outgoing->id }}, '{{ $outgoing->isApproved() ? 'unapprove' : 'approve' }}')"
                            class="{{ $outgoing->isApproved()
                                ? 'bg-orange-500 text-white hover:bg-orange-600'
                                : 'bg-green-600 text-white hover:bg-green-700' }} inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition">
                            @if ($outgoing->isApproved())
                                <span class="text-base">↺</span>
                                Unapprove
                            @else
                                <span class="text-base">✓</span>
                                Approve
                            @endif
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

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

        function confirmApproval(id, type) {
            let isUnapprove = type === 'unapprove';

            Swal.fire({
                title: isUnapprove ? 'Batalkan approval?' : 'Approve data?',
                text: isUnapprove ?
                    "Status akan kembali ke Pending." : "Data akan disetujui.",
                icon: isUnapprove ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: isUnapprove ? '#f97316' : '#16a34a',
                cancelButtonColor: '#4f46e5',
                confirmButtonText: isUnapprove ? 'Ya, Unapprove!' : 'Ya, Approve!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approval-form-' + id).submit();
                }
            })
        }

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

        function printInspeksi() {
            window.print();
        }
    </script>

    {{-- ==================== PRINT SECTION ==================== --}}
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            #print-section.hidden {
                display: block !important;
            }
        }
    </style>
    <div id="print-section" class="hidden">
        {{-- Header --}}
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 20%; vertical-align: middle;">
                    <img src="{{ asset('img/logobeva.png') }}" alt="Logo" style="height: 60px; width: auto;" />
                </td>
                <td style="width: 60%; vertical-align: middle; text-align: center;">
                    <h1 style="font-size: 18pt; font-weight: bold; margin: 0; font-family: Arial, sans-serif;">LAPORAN
                        INSPEKSI OUTGOING</h1>
                </td>
                <td
                    style="width: 20%; vertical-align: top; text-align: right; font-family: Arial, sans-serif; font-size: 11pt;">
                    <table cellpadding="3" cellspacing="0" style="border: 1px solid #000; margin-left: auto;">
                        <tr>
                            <td style="font-weight: bold; font-size: 10pt;">BM-F-QC-XX R00</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <hr style="border: 1px solid #000; margin-bottom: 15px;">

        {{-- Data Header --}}
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif; font-size: 11pt;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Tanggal</td>
                <td style="width: 30%;">: {{ now()->format('d/m/Y') }}</td>
                <td style="width: 20%; font-weight: bold;">No Inspeksi</td>
                <td style="width: 30%;">: {{ $outgoing->nomor_inspeksi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Shipment ID</td>
                <td>: {{ $outgoing->shipment_id ?? '-' }}</td>
                <td style="font-weight: bold;">Sales Order</td>
                <td>: {{ $outgoing->so ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nomor DO</td>
                <td>: {{ $outgoing->no_do }}</td>
                <td style="font-weight: bold;">Produk</td>
                <td>: {{ $outgoing->produk }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Qty</td>
                <td>: {{ $outgoing->qty ?? '-' }}</td>
                <td style="font-weight: bold;">Lokasi</td>
                <td>: {{ $outgoing->lokasi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">No Kendaraan</td>
                <td>: {{ $outgoing->no_kendaraan }}</td>
                <td style="font-weight: bold;">Keterangan</td>
                <td>: {{ $outgoing->keterangan }}</td>
            </tr>
        </table>

        {{-- Tabel Hasil Inspeksi Outgoing --}}
        <div style="margin-bottom: 20px;">
            <h3 style="font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; margin-bottom: 8px;">Hasil
                Inspeksi Outgoing</h3>
            <table width="100%" cellpadding="4" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 3%;">No</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Inspektor</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Label</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Karat</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Penyok</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Kotor</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Galvanized</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Lasan</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Mesh</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">PVC</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Packing</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">QTY</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($outgoing->outgoinginspeksi as $inc)
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->user->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->label }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->karat }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->penyok }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->kotor }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->galvanized }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->lasan }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->mesh }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->pvc }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $inc->packing }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $inc->qty }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">
                                {{ \Carbon\Carbon::parse($inc->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13"
                                style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada data Inspeksi Outgoing</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tanda Tangan --}}
        <table width="100%" cellpadding="10" cellspacing="0"
            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 11pt; margin-top: 40px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Dibuat oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $outgoing->outgoinginspeksi->first()->user->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Inspektor</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Disetujui Oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $outgoing->approver->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Supervisor / Manager</p>
                </td>
            </tr>
        </table>
    </div>
    {{-- ==================== END PRINT SECTION ==================== --}}
</x-app-layout>
