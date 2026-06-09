@forelse ($ruangans as $index => $ruangan)
    <tr class="hover:bg-blue-50/50 transition">
        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
            {{ $index + 1 }}
        </td>

        <td class="px-6 py-4 font-bold text-[#131D4F] min-w-[260px]">
            {{ $ruangan->nama_ruangan }}
        </td>

        <td class="px-6 py-4 text-gray-600 min-w-[260px]">
            {{ $ruangan->lokasi }}
        </td>

        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
            {{ $ruangan->kapasitas }} orang
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            @if ($ruangan->status_ruangan === 'tersedia')
                <span class="inline-flex items-center whitespace-nowrap rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center whitespace-nowrap rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                    Tidak Tersedia
                </span>
            @endif
        </td>

        @if (Auth::user()->role === 'admin')
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center justify-center gap-3">
                    <a
                        href="{{ route('ruangan.edit', $ruangan->id_ruangan) }}"
                        class="w-11 h-11 rounded-xl bg-yellow-400 text-[#131D4F] flex items-center justify-center hover:bg-yellow-500 transition shadow-sm"
                        title="Edit Ruangan"
                    >
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <form
                        method="POST"
                        action="{{ route('ruangan.destroy', $ruangan->id_ruangan) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="w-11 h-11 rounded-xl bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition shadow-sm"
                            title="Hapus Ruangan"
                        >
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        @endif
    </tr>
@empty
    <tr>
        <td
            colspan="{{ Auth::user()->role === 'admin' ? 6 : 5 }}"
            class="px-6 py-10 text-center text-gray-500"
        >
            Data ruangan tidak ditemukan.
        </td>
    </tr>
@endforelse
