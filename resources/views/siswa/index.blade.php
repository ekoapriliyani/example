<x-layout>
    <h1 class="text-xl mb-5 font-bold">Daftar Siswa</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y-2 divide-gray-200">
            <thead class="ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-gray-900">
                    <th class="px-3 py-2 whitespace-nowrap">Nama</th>
                    <th class="px-3 py-2 whitespace-nowrap">Tanggal Lahir</th>
                    <th class="px-3 py-2 whitespace-nowrap">Jurusan</th>
                    <th class="px-3 py-2 whitespace-nowrap">Nilai</th>
                    <th class="px-3 py-2 whitespace-nowrap">Details</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach ($data as $item)
                    <tr class="*:text-gray-900 *:first:font-medium">
                        <td class="px-3 py-2 whitespace-nowrap">{{ $item['nama'] }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $item['tanggal_lahir'] }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $item['jurusan'] }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $item['nilai'] }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            <a href="/siswa/{{ $item['id'] }}" class="text-teal-500 font-bold hover:opacity-50">View
                                Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-slot:footer>
        <strong>Siswa Page</strong>
    </x-slot:footer>
</x-layout>
