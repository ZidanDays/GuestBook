<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Rekap Buku Tamu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">

        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rekap Data Tamu</h1>
                <p class="text-gray-500 text-sm">Daftar kunjungan tamu yang telah tersimpan.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('guest-books.create') }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700">+ Tambah Tamu Baru</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter / Pencarian -->
        <div class="bg-white p-4 rounded-xl shadow-sm mb-6">
            <form method="GET" action="{{ route('guest-books.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau tujuan..." class="w-full border border-gray-300 rounded-lg p-2 text-sm">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">Cari</button>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b text-gray-700">
                            <th class="p-4">Foto</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Nama / NIK</th>
                            <th class="p-4">Jabatan</th>
                            <th class="p-4">Maksud / Tujuan</th>
                            <th class="p-4">Alamat</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($guests as $guest)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4">
                                    @if($guest->foto)
                                        <img src="{{ asset('storage/' . $guest->foto) }}" alt="Foto" class="w-12 h-12 object-cover rounded-lg border">
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-4 font-medium">{{ $guest->tanggal->format('d/m/Y') }}</td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $guest->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $guest->nik_nip ?? '-' }}</div>
                                </td>
                                <td class="p-4 text-gray-600">{{ $guest->jabatan ?? '-' }}</td>
                                <td class="p-4 text-gray-700 max-w-xs truncate">{{ $guest->maksud_tujuan }}</td>
                                <td class="p-4 text-gray-600 max-w-xs truncate">{{ $guest->alamat }}</td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('guest-books.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400">Belum ada data kunjungan tamu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $guests->links() }}
            </div>
        </div>
    </div>
</body>
</html>
