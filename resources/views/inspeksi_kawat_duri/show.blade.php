<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Inspeksi Kawat Duri') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('inspeksi_kawat_duri.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    Kembali
                </a>
                <a href="{{ route('inspeksi_kawat_duri.wip', $inspeksiKawatDuri->id) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah WIP
                </a>
                <a href="{{ route('inspeksi_kawat_duri.fg', $inspeksiKawatDuri->id) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah FG
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
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Nomor Inspeksi</dt>
                                <dd class="text-lg font-bold text-indigo-600">{{ $inspeksiKawatDuri->nomor_inspeksi }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">PRO Number</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiKawatDuri->pro->pro_id }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Description</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiKawatDuri->pro->description }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">QTY Ordered</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiKawatDuri->pro->qty }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Shift</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiKawatDuri->shift }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Type Coating</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiKawatDuri->type_coating }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 italic">Mesin</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $inspeksiKawatDuri->mesin->nama_mesin }}
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
                        <h3 class="text-lg font-bold text-gray-800">Hasil Inspeksi WIP Kawat Duri</h3>
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
                                    <th class="px-4 py-3 font-semibold text-gray-900">Diameter Jalinan</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Jarak Duri</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Jumlah Jalinan Duri</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Sudut Ujung Duri</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Weight</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Jumlah Counter</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Aksi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-center">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inspeksiKawatDuri->inspeksiKawatDuriWip as $wip)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $wip->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $wip->no_material }}</td>
                                        <td class="px-4 py-3">{{ $wip->nama_operator }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->d_kawat_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->d_kawat_jalinan_act }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->jarak_duri }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->jml_jalinan_duri }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->sudut_ujung_duri }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->weight }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->jml_counter }}</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->status }}</td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleDetail2({{ $wip->id }})">
                                                Lihat Detail
                                            </button>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleImage2({{ $wip->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">EDIT DELETE</td>
                                        <td class="px-4 py-3 text-center bg-blue-50/30">{{ $wip->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-400 italic">Belum
                                            ada
                                            data WIP untuk inspeksi ini.</td>
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
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Data Finished Goods (FG)</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-900">No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Inspektor</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Quantity</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Weight</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Detail</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Gambar</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inspeksiKawatDuri->inspeksiKawatDuriFg as $fg)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $fg->user->name }}</td>
                                        <td class="px-4 py-3 font-medium">
                                            @if ($fg->status === 'OK')
                                                <span class="px-2 py-1 rounded bg-green-100 text-green-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @elseif($fg->status === 'NG')
                                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @elseif($fg->status === 'REJECT')
                                                <span class="px-2 py-1 rounded bg-red-100 text-red-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-800">
                                                    {{ $fg->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $fg->qty }}</td>
                                        <td class="px-4 py-3">{{ $fg->weight }} Kg</td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleDetail({{ $fg->id }})">
                                                Lihat Detail
                                            </button>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button" class="text-sm text-indigo-600 hover:underline"
                                                onclick="toggleImage({{ $fg->id }})">
                                                Lihat Gambar
                                            </button>
                                        </td>
                                        <td class="px-4 py-3">{{ $fg->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-400 italic">Belum
                                            ada data FG untuk inspeksi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- modal detail fg --}}
                        @foreach ($inspeksiKawatDuri->inspeksiKawatDuriFg as $fg)
                            <div id="detail-{{ $fg->id }}"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                                    <h3 class="text-lg font-semibold mb-4">Detail FG: {{ $fg->batch_number }}</h3>
                                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2">No</th>
                                                <th class="px-4 py-2">Description</th>
                                                <th class="px-4 py-2">Description 2</th>
                                                <th class="px-4 py-2">QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @forelse ($fg->details as $detail)
                                                <tr>
                                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                    <td class="px-4 py-2">{{ $detail->description }}</td>
                                                    <td class="px-4 py-2">{{ $detail->description2 }}</td>
                                                    <td class="px-4 py-2">{{ $detail->qty }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
                                                        class="px-4 py-4 text-center text-gray-400 italic">
                                                        Belum ada detail untuk FG ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="mt-4 text-right">
                                        <button onclick="toggleDetail({{ $fg->id }})"
                                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        {{-- modal detail wip --}}
                        @foreach ($inspeksiKawatDuri->inspeksiKawatDuriWip as $wip)
                            <div id="detail2-{{ $wip->id }}"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                                    {{-- <h3 class="text-lg font-semibold mb-4">Detail FG: {{ $wip->batch_number }}</h3> --}}
                                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2">No</th>
                                                <th class="px-4 py-2">Description</th>
                                                <th class="px-4 py-2">Description 2</th>
                                                <th class="px-4 py-2">QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @forelse ($wip->inspeksiKdWipDetails as $detail)
                                                <tr>
                                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                                    <td class="px-4 py-2">{{ $detail->description }}</td>
                                                    <td class="px-4 py-2">{{ $detail->description2 }}</td>
                                                    <td class="px-4 py-2">{{ $detail->qty }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3"
                                                        class="px-4 py-4 text-center text-gray-400 italic">
                                                        Belum ada detail untuk WIP ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="mt-4 text-right">
                                        <button onclick="toggleDetail2({{ $wip->id }})"
                                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- modal gambar fg --}}
                        @foreach ($inspeksiKawatDuri->inspeksiKawatDuriFg as $fg)
                            <div id="image-{{ $fg->id }}"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                                    {{-- <h3 class="text-lg font-semibold mb-4">Gambar FG: {{ $fg->batch_number }}</h3> --}}

                                    @if ($fg->files)
                                        <div class="space-y-4">
                                            @foreach ($fg->files as $file)
                                                @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp

                                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/' . $file) }}" alt="FG Image"
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
                                        <button onclick="toggleImage({{ $fg->id }})"
                                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- modal gambar wip --}}
                        @foreach ($inspeksiKawatDuri->inspeksiKawatDuriWip as $wip)
                            <div id="image2-{{ $wip->id }}"
                                class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                <div class="bg-white rounded-lg shadow-lg w-3/4 p-6 max-h-[80vh] overflow-y-auto">
                                    {{-- <h3 class="text-lg font-semibold mb-4">Gambar WIP: {{ $wip->batch_number }}</h3> --}}

                                    @if ($wip->files)
                                        <div class="space-y-4">
                                            @foreach ($wip->files as $file)
                                                @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp

                                                @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ asset('storage/' . $file) }}" alt="Wip Image"
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
                                        <button onclick="toggleImage2({{ $wip->id }})"
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

            {{-- section approval --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                        <!-- Left -->
                        <div class="flex items-start gap-4">
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-100 to-emerald-50 text-green-600 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    Approval Inspeksi Kawat Duri
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Review data inspeksi sebelum melakukan approval.
                                </p>
                            </div>
                        </div>
                        <!-- Middle + Right -->
                        <div class="flex items-center gap-4">
                            <!-- Status -->
                            @if ($inspeksiKawatDuri->isApproved())
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
                                <form id="approval-form-{{ $inspeksiKawatDuri->id }}"
                                    action="{{ route('inspeksi-kawat-duri.toggle', $inspeksiKawatDuri->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <button type="button"
                                    onclick="confirmApproval({{ $inspeksiKawatDuri->id }}, '{{ $inspeksiKawatDuri->isApproved() ? 'unapprove' : 'approve' }}')"
                                    class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition
                        {{ $inspeksiKawatDuri->isApproved()
                            ? 'bg-orange-500 text-white hover:bg-orange-600'
                            : 'bg-green-600 text-white hover:bg-green-700' }}">
                                    @if ($inspeksiKawatDuri->isApproved())
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
        </div>
    </div>
    </div>


    <script>
        function toggleDetail(id) {
            const modal = document.getElementById('detail-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleDetail2(id) {
            const modal = document.getElementById('detail2-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleImage(id) {
            const modal = document.getElementById('image-' + id);
            modal.classList.toggle('hidden');
        }
    </script>
    <script>
        function toggleImage2(id) {
            const modal = document.getElementById('image2-' + id);
            modal.classList.toggle('hidden');
        }
    </script>

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
    </script>
</x-app-layout>
