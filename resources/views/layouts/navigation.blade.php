<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-gray-100 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <div class="hidden sm:ms-4 sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    <div>Inspeksi Reguler</div>
                                    <div class="ms-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('inspeksi_wm.index')">Wiremesh (WM)</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_wf.index')">Wafios/EVG</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_fencing.index')">Fencing</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_ct.index')">CTCL</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_kawat_duri.index')">Kawat Duri</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_chainlink.index')">Chainlink</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_pvc.index')">PVC</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_slitting.index')">Razor Slitting</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_pound.index')">Razor Pound</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_klip.index')">Razor Klip</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_razorpacking.index')">Razor Packing</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_shearing.index')">Shearing</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_gabionframe.index')">Gabion Frame</x-dropdown-link>
                                <x-dropdown-link :href="route('inspeksi_gabionanyam.index')">Gabion Anyam</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- incoming --}}
                    <div class="hidden sm:ms-4 sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    <div>Inspeksi Incoming</div>
                                    <div class="ms-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('incomingbahanbaku.index')">Bahan Baku</x-dropdown-link>
                                <x-dropdown-link :href="route('sheetgalvanize.index')">Sheet Galvanized</x-dropdown-link>
                                <x-dropdown-link :href="route('incomingpvchdpe.index')">PVC HDPE</x-dropdown-link>
                                <x-dropdown-link :href="route('incomingproject.index')">Incoming Project</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="hidden sm:ms-4 sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    <div>Master</div>
                                    <div class="ms-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
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
                                {{-- <x-dropdown-link :href="route('user.index')">User</x-dropdown-link> --}}
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="hidden sm:ms-4 sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    <div>Transaction</div>
                                    <div class="ms-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('pro.index')">PRO</x-dropdown-link>
                                <x-dropdown-link :href="route('shipment.index')">Shipment</x-dropdown-link>

                                {{-- <x-dropdown-link :href="route('user.index')">User</x-dropdown-link> --}}
                            </x-slot>
                        </x-dropdown>
                    </div>






                    <div class="hidden sm:ms-4 sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    <div>Inspeksi Project</div>
                                    <div class="ms-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                {{-- <x-dropdown-link :href="route('project.index')">Project</x-dropdown-link> --}}
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
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

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
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
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>

            <div class="border-t border-gray-200 pt-2">
                <div class="px-4 text-xs font-semibold uppercase text-gray-400">Inspeksi Reguler</div>
                <x-responsive-nav-link :href="route('inspeksi_wm.index')">Wiremesh (WM)</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_wf.index')">Wafios/EVG</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_fencing.index')">Fencing</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_ct.index')">CTCL</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_kawat_duri.index')">Kawat Duri</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_chainlink.index')">Chainlink</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_pvc.index')">PVC</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_slitting.index')">Razor Slitting</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_pound.index')">Razor Pound</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_klip.index')">Razor Klip</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_razorpacking.index')">Razor Packing</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_shearing.index')">Shearing</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_gabionframe.index')">Gabion Frame</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inspeksi_gabionanyam.index')">Gabion Anyam</x-responsive-nav-link>
            </div>
            <div class="border-t border-gray-200 pt-2">
                <div class="px-4 text-xs font-semibold uppercase text-gray-400">Inspeksi Incoming</div>
                <x-responsive-nav-link :href="route('incomingbahanbaku.index')">Bahan Baku</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sheetgalvanize.index')">Sheet Galvanize</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('incomingpvchdpe.index')">PVC HDPE</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('incomingproject.index')">Incoming Project</x-responsive-nav-link>
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
            </div>

            <div class="border-t border-gray-200 pt-2">
                <div class="px-4 text-xs font-semibold uppercase text-gray-400">Transaction</div>
                <x-responsive-nav-link :href="route('pro.index')">PRO</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('shipment.index')">Shipment</x-responsive-nav-link>
            </div>



            <div class="border-t border-gray-200 pt-2">
                <div class="px-4 text-xs font-semibold uppercase text-gray-400">Inspeksi Project</div>
                {{-- <x-responsive-nav-link :href="route('project.index')">Project</x-responsive-nav-link> --}}
            </div>
        </div>
    </div>
</nav>
