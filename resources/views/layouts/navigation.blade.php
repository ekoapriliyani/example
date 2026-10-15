@php
    $isActive = fn (string ...$patterns) => request()->routeIs(...$patterns);

    // Kelas tombol icon desktop: aktif (indigo) vs normal (abu-abu)
    $iconClass = fn (bool $active) => implode(' ', array_filter([
        'group relative inline-flex items-center rounded-md p-2.5 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1',
        $active
            ? 'bg-indigo-50 text-indigo-600'
            : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700',
    ]));
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-gray-100 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{--
                    Menu desktop: icon-only, nama muncul saat hover (tooltip).
                    Urutan: Dashboard, Inspeksi Incoming, Inspeksi Reguler, Outgoing,
                    Daftar NG/REJECT, LKS, Laporan (di kanan LKS), Master, Transaction.
                --}}
                <div class="hidden sm:-my-px sm:ms-6 sm:flex sm:items-center sm:space-x-1">

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" aria-label="Dashboard"
                        class="{{ $iconClass($isActive('dashboard')) }}">
                        <x-menu-icon name="dashboard" />
                        <x-nav-tooltip label="Dashboard" />
                    </a>

                    {{-- Inspeksi Incoming (dropdown) --}}
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" aria-label="Inspeksi Incoming" aria-haspopup="true"
                                class="{{ $iconClass($isActive('incomingbahanbaku.*', 'sheetgalvanize.*', 'incomingpvchdpe.*', 'incomingproject.*')) }} gap-1">
                                <x-menu-icon name="incoming" />
                                <x-menu-icon name="chevron-down" class="h-3 w-3 opacity-60" />
                                <x-nav-tooltip label="Inspeksi Incoming" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('incomingbahanbaku.index')">Bahan Baku</x-dropdown-link>
                            <x-dropdown-link :href="route('sheetgalvanize.index')">Sheet Galvanized</x-dropdown-link>
                            <x-dropdown-link :href="route('incomingpvchdpe.index')">PVC HDPE</x-dropdown-link>
                            <x-dropdown-link :href="route('incomingproject.index')">Incoming Project</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    {{-- Inspeksi Reguler (dropdown) --}}
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" aria-label="Inspeksi Reguler" aria-haspopup="true"
                                class="{{ $iconClass($isActive('inspeksi_*')) }} gap-1">
                                <x-menu-icon name="reguler" />
                                <x-menu-icon name="chevron-down" class="h-3 w-3 opacity-60" />
                                <x-nav-tooltip label="Inspeksi Reguler" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('inspeksi_gabionanyam.index')">Gabion Anyam</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_shearing.index')">Shearing</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_gabionframe.index')">Gabion Frame</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_gabionrakit.index')">Gabion Rakit</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_gabionpacking.index')">Gabion Packing</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_wf.index')">Wafios/EVG</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_wm.index')">Wiremesh (WM)</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_chainlink.index')">Chainlink</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_kawat_duri.index')">Kawat Duri</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_slitting.index')">Razor Slitting</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_pound.index')">Razor Pound</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_klip.index')">Razor Klip</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_razorpacking.index')">Razor Packing</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_pvc.index')">PVC</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_fencing.index')">Fencing</x-dropdown-link>
                            <x-dropdown-link :href="route('inspeksi_ct.index')">CTCL</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    {{-- Outgoing --}}
                    <a href="{{ route('outgoing.index') }}" aria-label="Outgoing"
                        class="{{ $iconClass($isActive('outgoing.index')) }}">
                        <x-menu-icon name="outgoing" />
                        <x-nav-tooltip label="Outgoing" />
                    </a>

                    {{-- Daftar NG/REJECT --}}
                    <a href="{{ route('daftar_ng_reject.index') }}" aria-label="Daftar NG/REJECT"
                        class="{{ $iconClass($isActive('daftar_ng_reject.index')) }}">
                        <x-menu-icon name="reject" />
                        <x-nav-tooltip label="Daftar NG/REJECT" />
                    </a>

                    {{-- LKS --}}
                    <a href="{{ route('lks.index') }}" aria-label="LKS"
                        class="{{ $iconClass($isActive('lks.*')) }}">
                        <x-menu-icon name="lks" />
                        <x-nav-tooltip label="LKS" />
                    </a>

                    {{-- Laporan (dropdown) - di sebelah kanan LKS --}}
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" aria-label="Laporan" aria-haspopup="true"
                                class="{{ $iconClass($isActive('laporan.*')) }} gap-1">
                                <x-menu-icon name="laporan" />
                                <x-menu-icon name="chevron-down" class="h-3 w-3 opacity-60" />
                                <x-nav-tooltip label="Laporan" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('laporan.incoming')">Laporan Incoming</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    {{-- Master (dropdown) --}}
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" aria-label="Master" aria-haspopup="true"
                                class="{{ $iconClass($isActive('mesin.*', 'material.*', 'subkon.*', 'supplier.*', 'product*', 'project.*', 'users.*')) }} gap-1">
                                <x-menu-icon name="master" />
                                <x-menu-icon name="chevron-down" class="h-3 w-3 opacity-60" />
                                <x-nav-tooltip label="Master" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('mesin.index')">Mesin</x-dropdown-link>
                            <x-dropdown-link :href="route('material.index')">Material</x-dropdown-link>
                            <x-dropdown-link :href="route('subkon.index')">Subkon</x-dropdown-link>
                            <x-dropdown-link :href="route('supplier.index')">Supllier</x-dropdown-link>
                            <x-dropdown-link :href="route('productwm.index')">Product Wiremesh</x-dropdown-link>
                            <x-dropdown-link :href="route('productFencing.index')">Product Fencing</x-dropdown-link>
                            <x-dropdown-link :href="route('productct.index')">Product CTCL</x-dropdown-link>
                            <x-dropdown-link :href="route('productrazor.index')">Product Razor</x-dropdown-link>
                            <x-dropdown-link :href="route('project.index')">Project</x-dropdown-link>
                            @if (auth()->user()->hasAnyRole(['administrator', 'manager']))
                                <x-dropdown-link :href="route('users.index')">Users</x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>

                    {{-- Transaction (dropdown) --}}
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" aria-label="Transaction" aria-haspopup="true"
                                class="{{ $iconClass($isActive('pro.*', 'shipment*', 'receiving_bi.*')) }} gap-1">
                                <x-menu-icon name="transaction" />
                                <x-menu-icon name="chevron-down" class="h-3 w-3 opacity-60" />
                                <x-nav-tooltip label="Transaction" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('pro.index')">PRO</x-dropdown-link>
                            <x-dropdown-link :href="route('shipment.index')">Shipment</x-dropdown-link>
                            <x-dropdown-link :href="route('shipment_bi.index')">Shipment BI</x-dropdown-link>
                            <x-dropdown-link :href="route('receiving_bi.index')">Receiving BI</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            {{-- User (icon avatar, nama muncul saat hover) --}}
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" aria-label="{{ Auth::user()->name }}"
                            class="{{ $iconClass($isActive('profile.*')) }} gap-1.5 ps-1.5">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold uppercase text-indigo-700 ring-1 ring-indigo-200">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                            <x-menu-icon name="chevron-down" class="h-3 w-3 opacity-60" />
                            <x-nav-tooltip :label="Auth::user()->name" />
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Tombol hamburger (mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" aria-label="Buka menu"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{--
            Menu mobile: icon + teks (hover tidak ada di layar sentuh, jadi nama
            tetap ditampilkan). Urutan menyesuaikan desktop: Laporan tepat setelah LKS.
        --}}
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="space-y-1 pb-3 pt-2">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <span class="flex items-center gap-3">
                        <x-menu-icon name="dashboard" class="h-5 w-5 shrink-0" />
                        {{ __('Dashboard') }}
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('outgoing.index')" :active="request()->routeIs('outgoing.index')">
                    <span class="flex items-center gap-3">
                        <x-menu-icon name="outgoing" class="h-5 w-5 shrink-0" />
                        {{ __('Outgoing') }}
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('daftar_ng_reject.index')"
                    :active="request()->routeIs('daftar_ng_reject.index')">
                    <span class="flex items-center gap-3">
                        <x-menu-icon name="reject" class="h-5 w-5 shrink-0" />
                        {{ __('Daftar NG/REJECT') }}
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('lks.index')" :active="request()->routeIs('lks.*')">
                    <span class="flex items-center gap-3">
                        <x-menu-icon name="lks" class="h-5 w-5 shrink-0" />
                        {{ __('LKS') }}
                    </span>
                </x-responsive-nav-link>

                {{-- Laporan - setelah LKS --}}
                <x-responsive-nav-link :href="route('laporan.incoming')" :active="request()->routeIs('laporan.*')">
                    <span class="flex items-center gap-3">
                        <x-menu-icon name="laporan" class="h-5 w-5 shrink-0" />
                        {{ __('Laporan') }}
                    </span>
                </x-responsive-nav-link>

                <div class="border-t border-gray-200 pt-2">
                    <div class="px-4 text-xs font-semibold uppercase text-gray-400">Inspeksi Incoming</div>
                    <x-responsive-nav-link :href="route('incomingbahanbaku.index')">Bahan Baku</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('sheetgalvanize.index')">Sheet Galvanize</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('incomingpvchdpe.index')">PVC HDPE</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('incomingproject.index')">Incoming Project</x-responsive-nav-link>
                </div>

                <div class="border-t border-gray-200 pt-2">
                    <div class="px-4 text-xs font-semibold uppercase text-gray-400">Inspeksi Reguler</div>
                    <x-responsive-nav-link :href="route('inspeksi_gabionanyam.index')">Gabion Anyam</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_shearing.index')">Shearing</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_gabionframe.index')">Gabion Frame</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_gabionrakit.index')">Gabion Rakit</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_gabionpacking.index')">Gabion Packing</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_wf.index')">Wafios/EVG</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_wm.index')">Wiremesh (WM)</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_chainlink.index')">Chainlink</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_kawat_duri.index')">Kawat Duri</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_slitting.index')">Razor Slitting</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_pound.index')">Razor Pound</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_klip.index')">Razor Klip</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_razorpacking.index')">Razor Packing</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_pvc.index')">PVC</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_fencing.index')">Fencing</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('inspeksi_ct.index')">CTCL</x-responsive-nav-link>
                </div>

                <div class="border-t border-gray-200 pt-2">
                    <div class="px-4 text-xs font-semibold uppercase text-gray-400">Master</div>
                    <x-responsive-nav-link :href="route('mesin.index')">Mesin</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('material.index')">Material</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('subkon.index')">Subkon</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('supplier.index')">Supplier</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('productwm.index')">Product WM</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('productFencing.index')">Product Fencing</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('productct.index')">Product CTCL</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('productrazor.index')">Product Razor</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('project.index')">Project</x-responsive-nav-link>
                    @if (auth()->user()->hasAnyRole(['administrator', 'manager']))
                        <x-responsive-nav-link :href="route('users.index')">Users</x-responsive-nav-link>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-2">
                    <div class="px-4 text-xs font-semibold uppercase text-gray-400">Transaction</div>
                    <x-responsive-nav-link :href="route('pro.index')">PRO</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('shipment.index')">Shipment</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('shipment_bi.index')">Shipment BI</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('receiving_bi.index')">Receiving BI</x-responsive-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
