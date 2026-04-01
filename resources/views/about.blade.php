<x-layout>
    <h1>Hello from about page view</h1>
    <h2>My name is {{ $nama }}</h2>
    <h2>Umur saya {{ $umur }} tahun</h2>

    @if ($umur > 18)
        <h3>you have rights to vote president</h3>
    @else
        <h3>you dont have rights to vote</h3>
    @endif

    <x-slot:footer>
        <strong>About Page</strong>
    </x-slot:footer>
</x-layout>
