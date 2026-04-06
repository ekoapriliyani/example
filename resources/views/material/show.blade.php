<x-layout>
    <div class="flow-root">
        <dl class="-my-3 divide-y divide-gray-200 text-sm">
            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Item ID</dt>

                <dd class="text-gray-700 sm:col-span-2">{{ $material->item_id }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Description</dt>

                <dd class="text-gray-700 sm:col-span-2">{{ $material->description }}</dd>
            </div>
        </dl>
    </div>

    <x-slot:footer>
        <strong>Material Detail Page</strong>
    </x-slot:footer>
</x-layout>
