<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QC System - Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="h-full">
    <div class="flex">
        <div class="flex h-screen w-64 flex-col justify-between border-e bg-white sticky top-0">
            <div class="px-4 py-6">
                <span class="grid h-10 w-32 place-content-center rounded-lg bg-teal-600 text-white">
                    <h3>QC System</h3>
                </span>

                <ul class="mt-6 space-y-1">
                    <li>
                        <x-nav-link href="/" :active="request()->is('/')"
                            class="block rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-100">
                            Home
                        </x-nav-link>
                    </li>
                    <li>
                        <details class="group [&_summary::-webkit-details-marker]:hidden">
                            <summary
                                class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                <span class="text-sm font-medium"> Master </span>
                                <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </summary>

                            <ul class="mt-2 space-y-1 px-4">
                                <li>
                                    <x-nav-link href="{{ route('mesin.index') }}" :active="request()->routeIs('mesin.index')"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Mesin
                                    </x-nav-link>
                                </li>
                                <li>
                                    <x-nav-link href="{{ route('material.index') }}" :active="request()->routeIs('material.index')"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-100">
                                        Material
                                    </x-nav-link>
                                </li>

                            </ul>
                        </details>
                    </li>
                </ul>
            </div>

            <div class="sticky inset-x-0 bottom-0 border-t border-gray-100">
                <a href="#" class="flex items-center gap-2 bg-white p-4 hover:bg-gray-50">
                    <img alt="User" src="https://ui-avatars.com/api/?name=User"
                        class="size-10 rounded-full object-cover" />
                    <div>
                        <p class="text-xs">
                            <strong class="block font-medium">IT Bevananda</strong>
                            <span> edp@bevananda.com </span>
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <div class="flex-1 flex flex-col min-h-screen">
            @if (session('success'))
                <div id="flash" class="p-4 bg-green-500 text-white text-center font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <main class="p-8">
                {{ $slot }}
            </main>

            <footer class="mt-auto p-8 border-t bg-white text-sm text-gray-500">
                Ini footer dari page: <strong>{{ $footer }}</strong>
            </footer>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash');
            if (flash) flash.style.display = 'none';
        }, 3000);
    </script>
</body>

</html>
