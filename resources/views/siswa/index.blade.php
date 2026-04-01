<x-layout>
    <h1>Daftar Siswa</h1>
    <ul>
        @foreach ($data as $item)
            <li>
                <h3>{{ $item['nama'] }} - {{ $item['nilai'] }}</h3>
            </li>
        @endforeach
    </ul>
    <x-slot:footer>
        <strong>Siswa Page</strong>
    </x-slot:footer>
</x-layout>
