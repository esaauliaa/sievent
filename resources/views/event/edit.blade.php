<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow sm:rounded-xl border border-gray-100 p-6 space-y-6">
                
                <div>
                    <h3 class="text-lg font-bold text-[#131D4F]">Edit Data Informasi Event</h3>
                    <p class="text-xs text-gray-400">Ubah konfigurasi detail event yang ingin Anda perbaiki.</p>
                </div>

                <form action="{{ route('event.update', $event->id_event) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-sm text-gray-700">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block font-medium text-[#131D4F] mb-1">Nama Event / Kegiatan</label>
                        <input type="text" name="nama_event" value="{{ $event->nama_event }}" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#131D4F] mb-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">{{ $event->deskripsi }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Pilih Ruangan Kampus</label>
                            <select name="id_ruangan" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id_ruangan }}" {{ $event->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Kuota Maksimal Peserta</label>
                            <input type="number" name="kuota" value="{{ $event->kuota }}" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" value="{{ $event->tanggal_pelaksanaan }}" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">
                        </div>
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Waktu Mulai Acara</label>
                            <input type="time" name="waktu_mulai" value="{{ $event->waktu_mulai }}" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">
                        </div>
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Waktu Selesai Acara</label>
                            <input type="time" name="waktu_selesai" value="{{ $event->waktu_selesai }}" required class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-[#0056B3] focus:border-[#0056B3]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Ganti Poster Baru (Opsional)</label>
                            <input type="file" name="poster" accept="image/*" class="w-full text-xs border border-gray-200 rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block font-medium text-[#131D4F] mb-1">Ganti Dokumen Proposal Baru (Opsional)</label>
                            <input type="file" name="proposal" accept=".pdf" class="w-full text-xs border border-gray-200 rounded-lg p-2">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100 font-medium">
                        <a href="{{ route('event.index') }}" class="px-4 py-2 border rounded-lg text-gray-500 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-5 py-2 bg-[#0056B3] hover:bg-[#131D4F] text-white rounded-lg shadow transition">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>