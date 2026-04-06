<x-layout>
    <div class="flow-root">
        <dl class="-my-3 divide-y divide-gray-200 text-sm">
            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Nama</dt>
                <dd class="text-gray-700 sm:col-span-2">{{ $siswa->nama }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Tanggal Lahir</dt>
                <dd class="text-gray-700 sm:col-span-2">{{ $siswa->tanggal_lahir }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Jurusan</dt>
                <dd class="text-gray-700 sm:col-span-2">{{ $siswa->jurusan }}</dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Nilai</dt>
                <dd class="text-gray-700 sm:col-span-2">
                    {{ $siswa->nilai }}
                </dd>
            </div>

            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="font-medium text-gray-900">Nama Mentor</dt>
                <dd class="text-gray-700 sm:col-span-2">
                    {{ $siswa->mentor->nama }}
                </dd>
            </div>
        </dl>
    </div>
    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-white text-sm bg-teal-500 my-8 px-4 py-2 rounded cursor-pointer">
            Delete
        </button>
    </form>
    <x-slot:footer>
        <strong>Siswa Detail Page</strong>
    </x-slot:footer>
</x-layout>
