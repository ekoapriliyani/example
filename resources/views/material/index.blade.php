<x-layout>
    <h1 class="text-xl mb-5 font-bold">Daftar Material</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y-2 divide-gray-200">
            <thead class="ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-gray-900">
                    <th class="px-3 py-2 whitespace-nowrap">Item ID</th>
                    <th class="px-3 py-2 whitespace-nowrap">Description</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach ($data as $item)
                    <tr class="*:text-gray-900 *:first:font-medium">
                        <td class="px-3 py-2 whitespace-nowrap">{{ $item->item_id }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $item->description }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <a href="{{ route('material.show', $item->id) }}"
                                class="text-teal-500 font-bold hover:opacity-50">View
                                Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="py-10">
        {{ $data->appends(request()->query())->links() }}
    </div>

    <x-slot:footer>
        <strong>Material Page</strong>
    </x-slot:footer>
</x-layout>
