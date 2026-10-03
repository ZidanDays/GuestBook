<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buku Tamu</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-md">

        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Formulir Buku Tamu</h1>
                <p class="text-gray-500 text-sm">Silakan isi data kunjungan Anda di bawah ini.</p>
            </div>
            @if (Route::has('login'))
            @auth
                <a href="{{ route('guest-books.index') }}" class="text-sm bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Dashboard Admin &rarr;</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Login Admin</a>
            @endauth
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('guest-books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                    @error('tanggal') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama..." required class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                    @error('nama') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- NIK / NIP -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK / NIP</label>
                    <input type="text" name="nik_nip" value="{{ old('nik_nip') }}" placeholder="Opsional" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan / Instansi</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Staff IT / Umum" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="2" required placeholder="Alamat lengkap..." class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <!-- Maksud & Tujuan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Maksud & Tujuan <span class="text-red-500">*</span></label>
                <textarea name="maksud_tujuan" rows="2" required placeholder="Tujuan kedatangan..." class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">{{ old('maksud_tujuan') }}</textarea>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Catatan opsional" class="w-full border-gray-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Foto Pengunjung (Kamera WebCam / File) -->
            <div class="border p-4 rounded-lg bg-gray-50">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Pengunjung</label>

                <div class="flex space-x-3 mb-3">
                    <button type="button" id="btn-camera-mode" class="px-3 py-1.5 text-xs font-semibold bg-blue-600 text-white rounded hover:bg-blue-700">Gunakan Kamera</button>
                    <button type="button" id="btn-file-mode" class="px-3 py-1.5 text-xs font-semibold bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Upload File</button>
                </div>

                <!-- Modul Kamera -->
                <div id="camera-section" class="space-y-3">
                    <div class="flex flex-col sm:flex-row gap-4 items-center">
                        <video id="webcam" width="280" height="210" autoplay class="border rounded bg-black"></video>
                        <canvas id="canvas" width="280" height="210" class="border rounded bg-gray-200 hidden"></canvas>
                    </div>
                    <button type="button" id="snap-btn" class="bg-emerald-600 text-white px-4 py-2 text-xs rounded hover:bg-emerald-700">Ambil Foto (Snap)</button>
                    <input type="hidden" name="foto_webcam" id="foto_webcam">
                </div>

                <!-- Modul Upload File -->
                <div id="file-section" class="hidden">
                    <input type="file" name="foto" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-medium py-3 rounded-lg hover:bg-blue-700 transition">
                Simpan Data Tamu
            </button>
        </form>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const snapBtn = document.getElementById('snap-btn');
        const inputWebcam = document.getElementById('foto_webcam');

        const cameraSection = document.getElementById('camera-section');
        const fileSection = document.getElementById('file-section');
        const btnCameraMode = document.getElementById('btn-camera-mode');
        const btnFileMode = document.getElementById('btn-file-mode');

        // Buka Stream Kamera
        function startCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => { video.srcObject = stream; })
                .catch(err => {
                    console.error("Akses kamera ditolak/tidak ditemukan:", err);
                    alert("Kamera tidak dapat diakses, silakan gunakan mode Upload File.");
                });
        }

        startCamera();

        // Switch Mode Input Foto
        btnCameraMode.addEventListener('click', () => {
            cameraSection.classList.remove('hidden');
            fileSection.classList.add('hidden');
            btnCameraMode.className = 'px-3 py-1.5 text-xs font-semibold bg-blue-600 text-white rounded hover:bg-blue-700';
            btnFileMode.className = 'px-3 py-1.5 text-xs font-semibold bg-gray-300 text-gray-700 rounded hover:bg-gray-400';
        });

        btnFileMode.addEventListener('click', () => {
            fileSection.classList.remove('hidden');
            cameraSection.classList.add('hidden');
            btnFileMode.className = 'px-3 py-1.5 text-xs font-semibold bg-blue-600 text-white rounded hover:bg-blue-700';
            btnCameraMode.className = 'px-3 py-1.5 text-xs font-semibold bg-gray-300 text-gray-700 rounded hover:bg-gray-400';
        });

        // Tangkap Gambar dari Kamera
        snapBtn.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, 280, 210);

            const dataUrl = canvas.toDataURL('image/png');
            inputWebcam.value = dataUrl;

            canvas.classList.remove('hidden');
            alert('Foto berhasil diambil!');
        });
    </script>
</body>
</html>
