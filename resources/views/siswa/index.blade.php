<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('siswa.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Siswa
                </a>
                <a href="{{ route('siswa.export', [
                        'lembaga_id' => request('lembaga_id'),
                        'search'     => request('search')
                    ]) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Export Excel
                </a>
            </div>
            <form method="GET" action="{{ route('siswa.index') }}" class="mb-4 flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block mb-1 font-semibold">Filter Lembaga:</label>
                    <select name="lembaga_id" class="border rounded px-3 py-2">
                        <option value="">Semua Lembaga</option>
                        @foreach($lembagas as $lembaga)
                            <option value="{{ $lembaga->id }}"
                                {{ request('lembaga_id') == $lembaga->id ? 'selected' : '' }}>
                                {{ $lembaga->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Search (NIS / Nama):</label>
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           class="border rounded px-3 py-2"
                           placeholder="Cari NIS / Nama">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded">
                        Terapkan
                    </button>

                    <a href="{{ route('siswa.index') }}"
                       class="px-4 py-2 bg-gray-300 rounded">
                        Reset
                    </a>
                </div>
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="table-siswa" class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="px-3 py-2 text-left">NIS</th>
                                <th class="px-3 py-2 text-left">Nama</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-left">Lembaga</th>
                                <th class="px-3 py-2 text-left">Foto</th>
                                <th class="px-3 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $siswa->nis }}</td>
                                    <td class="px-3 py-2">{{ $siswa->nama }}</td>
                                    <td class="px-3 py-2">{{ $siswa->email }}</td>
                                    <td class="px-3 py-2">{{ $siswa->lembaga->nama }}</td>
                                    <td class="px-3 py-2">
                                        @if($siswa->foto)
                                            <img src="{{ asset('storage/'.$siswa->foto) }}"
                                                 class="h-10 w-10 object-cover rounded-full" alt="foto">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('siswa.edit', $siswa) }}"
                                           class="text-blue-600 mr-2">Edit</a>

                                        <form action="{{ route('siswa.destroy', $siswa) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                                        Belum ada data siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#table-siswa').DataTable({
                paging: true,
                info: false,
                searching: false 
            });
        });
    </script>
    @endpush
</x-app-layout>
