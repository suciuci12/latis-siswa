<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}"
                               class="w-full border rounded px-3 py-2">
                        @error('nis') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}"
                               class="w-full border rounded px-3 py-2">
                        @error('nama') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $siswa->email) }}"
                               class="w-full border rounded px-3 py-2">
                        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Lembaga</label>
                        <select name="lembaga_id" class="w-full border rounded px-3 py-2">
                            @foreach($lembagas as $lembaga)
                                <option value="{{ $lembaga->id }}"
                                    {{ old('lembaga_id', $siswa->lembaga_id) == $lembaga->id ? 'selected' : '' }}>
                                    {{ $lembaga->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('lembaga_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Foto (JPG/PNG, max 100KB)</label>
                        @if($siswa->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$siswa->foto) }}"
                                     class="h-16 w-16 object-cover rounded-full" alt="foto">
                            </div>
                        @endif
                        <input type="file" name="foto" class="w-full">
                        @error('foto') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('siswa.index') }}" class="px-4 py-2 bg-gray-300 rounded">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
