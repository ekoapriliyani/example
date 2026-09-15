<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail LKS') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('lks.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    Kembali
                </a>
                <button type="button" onclick="printLks()"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
                @if ($lks->isDraft() && in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']))
                    <form action="{{ route('lks.approve', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition shadow-sm">
                            <span class="text-base">✓</span> Approve
                        </button>
                    </form>
                @endif
                @if ($lks->isApproved() && in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']))
                    <form action="{{ route('lks.approve', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-orange-500 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-600 transition shadow-sm">
                            <span class="text-base">↺</span> Unapprove
                        </button>
                    </form>
                    <form action="{{ route('lks.close', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition shadow-sm">
                            Close LKS
                        </button>
                    </form>
                @endif
                @if ($lks->isClosed() && in_array(auth()->user()->role, ['supervisor', 'manager', 'administrator']))
                    <form action="{{ route('lks.open', $lks->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                            <span class="text-base">🔓</span> Open LKS
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Info LKS --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <dl class="grid grid-cols-3 gap-x-8 gap-y-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Nomor LKS</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $lks->nomor_lks }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Supplier</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $lks->supplier->nama ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Tanggal</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($lks->tanggal)->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Status</dt>
                                <dd>
                                    @if ($lks->isDraft())
                                        <span class="inline-block rounded bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">DRAFT</span>
                                    @elseif ($lks->isApproved())
                                        <span class="inline-block rounded bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">APPROVED</span>
                                    @else
                                        <span class="inline-block rounded bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700">CLOSED</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="col-span-3 sm:col-span-4">
                                <dt class="text-sm font-medium text-gray-500 italic">Keterangan</dt>
                                <dd class="text-gray-900">{{ $lks->keterangan ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Lot --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="p-2 bg-red-100 rounded-lg text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Detail Lot Number NG / REJECT</h3>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Lot Number</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Sumber</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No Koil</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 1</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Description 2</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Tanggal Inspeksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($lks->details as $detail)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-semibold text-indigo-600">{{ $detail->lot_number }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $detail->sumber === 'inspeksi' ? 'text-blue-800 bg-blue-200' : 'text-green-800 bg-green-200' }}">
                                                {{ ucfirst($detail->sumber) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $detail->no_koil ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $detail->status === 'REJECT' ? 'text-red-800 bg-red-200' : 'text-yellow-800 bg-yellow-200' }}">
                                                {{ $detail->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $detail->description1 ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $detail->description2 ?? '-' }}</td>
                                        <td class="px-4 py-3 text-xs text-gray-500">{{ $detail->tanggal_inspeksi ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-400 italic">
                                            Belum ada detail lot number.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Print Section --}}
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }
            body * { visibility: hidden; }
            #print-section, #print-section * { visibility: visible; }
            #print-section { position: absolute; left: 0; top: 0; width: 100%; }
            #print-section.hidden { display: block !important; }
        }
    </style>
    <div id="print-section" class="hidden">
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 20%; vertical-align: middle;">
                    <img src="{{ asset('img/logobeva.png') }}" alt="Logo" style="height: 60px; width: auto;" />
                </td>
                <td style="width: 60%; vertical-align: middle; text-align: center;">
                    <h1 style="font-size: 18pt; font-weight: bold; margin: 0; font-family: Arial, sans-serif;">
                        LAPORAN KETIDAKSESUAIAN (LKS)</h1>
                </td>
                <td style="width: 20%; vertical-align: top; text-align: right; font-family: Arial, sans-serif; font-size: 11pt;">
                    <table cellpadding="3" cellspacing="0" style="border: 1px solid #000; margin-left: auto;">
                        <tr>
                            <td style="font-weight: bold; font-size: 10pt;">BM-F-QC-XX R00</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <hr style="border: 1px solid #000; margin-bottom: 15px;">

        <table width="100%" cellpadding="5" cellspacing="0"
            style="border-collapse: collapse; margin-bottom: 20px; font-family: Arial, sans-serif; font-size: 11pt;">
            <tr>
                <td style="width: 20%; font-weight: bold;">Nomor LKS</td>
                <td style="width: 30%;">: {{ $lks->nomor_lks }}</td>
                <td style="width: 20%; font-weight: bold;">Tanggal</td>
                <td style="width: 30%;">: {{ \Carbon\Carbon::parse($lks->tanggal)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Supplier</td>
                <td>: {{ $lks->supplier->nama ?? 'N/A' }}</td>
                <td style="font-weight: bold;">Status</td>
                <td>: {{ $lks->status }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Keterangan</td>
                <td colspan="3">: {{ $lks->keterangan ?? '-' }}</td>
            </tr>
        </table>

        <div style="margin-bottom: 20px;">
            <h3 style="font-family: Arial, sans-serif; font-size: 12pt; font-weight: bold; margin-bottom: 8px;">
                Detail Lot Number NG / REJECT</h3>
            <table width="100%" cellpadding="4" cellspacing="0"
                style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 9pt; border: 1px solid #000;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 3%;">No</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 15%;">Lot Number</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">Sumber</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 10%;">No Koil</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 8%;">Status</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 15%;">Description 1</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 15%;">Description 2</th>
                        <th style="border: 1px solid #000; padding: 5px; text-align: center; width: 12%;">Tanggal Inspeksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lks->details as $detail)
                        <tr>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $detail->lot_number }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ ucfirst($detail->sumber) }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $detail->no_koil ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $detail->status }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $detail->description1 ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px;">{{ $detail->description2 ?? '-' }}</td>
                            <td style="border: 1px solid #000; padding: 4px; text-align: center;">{{ $detail->tanggal_inspeksi ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="border: 1px solid #000; padding: 8px; text-align: center; font-style: italic;">
                                Belum ada detail lot number</td>
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
                        {{ $lks->approver->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Manager / Supervisor</p>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold;">Disetujui Oleh:</p>
                    <br><br><br>
                    <p style="margin: 0; border-top: 1px solid #000; width: 200px; padding-top: 5px;">
                        {{ $lks->approver->name ?? '.................' }}</p>
                    <p style="margin: 2px 0 0 0; font-style: italic;">Quality Manager</p>
                </td>
            </tr>
        </table>
    </div>

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

        function printLks() {
            document.getElementById('print-section').classList.remove('hidden');
            window.print();
            setTimeout(() => {
                document.getElementById('print-section').classList.add('hidden');
            }, 500);
        }
    </script>
</x-app-layout>
