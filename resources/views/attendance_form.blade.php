<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Rapat: {{ $meeting->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .canvas-container {
            border: 2px dashed #ccc;
            border-radius: 0.5rem;
            touch-action: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-2xl p-8 space-y-6 bg-white rounded-lg shadow-md">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">Formulir Kehadiran Rapat</h1>
            <p class="mt-2 text-lg text-gray-700">{{ $meeting->title }}</p>
            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($meeting->meeting_date)->isoFormat('D MMMM YYYY') }}</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('attendance.store') }}" method="POST" id="attendance-form">
            @csrf
            <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK / ID Karyawan</label>
                    <input type="text" name="nik" id="nik" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode Unit / Jabatan</label>
                    <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-2">
                        @php
                            $positions = [
                                'PKU.GMK', 'PKU.GOPC', 'PKU.GQSM', 'PKU.GBCC', 'PKU.GLEC',
                                'PKU.GAGS', 'PKU.OOS', 'PKU.OOSA', 'PKU.OOSL', 'PKU.OOSR',
                                'PKU.OOSC', 'PKU.TTE', 'PKU.TTEF', 'PKU.TTEQ', 'PKU.TTET',
                                'PKU.CCO', 'PKU.CCOA', 'PKU.CCON'
                            ];
                        @endphp
                        @foreach ($positions as $position)
                            <div class="flex items-center">
                                <input type="radio" name="position" id="pos-{{ str_replace('.', '', $position) }}" value="{{ $position }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 position-radio" required>
                                <label for="pos-{{ str_replace('.', '', $position) }}" class="ml-3 block text-sm font-medium text-gray-700">{{ $position }}</label>
                            </div>
                        @endforeach
                        <div class="flex items-center">
                            <input type="radio" name="position" id="pos-lainnya" value="Lainnya (Eksternal)" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 position-radio" checked required>
                            <label for="pos-lainnya" class="ml-3 block text-sm font-medium text-gray-700">Lainnya (Eksternal)</label>
                        </div>
                    </div>
                    <div id="other-position-wrapper" class="mt-2">
                         <input type="text" id="other-position-text" placeholder="Ketik jabatan/unit Anda di sini" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanda Tangan</label>
                    <div class="mt-1 canvas-container">
                        <canvas id="signature-pad" class="w-full h-40"></canvas>
                    </div>
                    <button type="button" id="clear-signature" class="mt-2 text-sm text-blue-600 hover:text-blue-800">Bersihkan</button>
                    <input type="hidden" name="signature" id="signature-data">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Kirim Absensi
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ... (kode signature pad tetap sama) ...
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
            document.getElementById('clear-signature').addEventListener('click', function () {
                signaturePad.clear();
            });

            // ==========================================================
            // LOGIKA BARU UNTUK INPUT JABATAN/UNIT LAINNYA
            // ==========================================================
            const radioButtons = document.querySelectorAll('.position-radio');
            const otherPositionWrapper = document.getElementById('other-position-wrapper');
            const otherPositionText = document.getElementById('other-position-text');
            const lainnyaRadio = document.getElementById('pos-lainnya');

            function toggleOtherPosition() {
                if (lainnyaRadio.checked) {
                    otherPositionWrapper.classList.remove('hidden');
                    otherPositionText.required = true;
                    // Saat memilih 'Lainnya', value radio buttonnya langsung diisi dari teks input
                    lainnyaRadio.value = otherPositionText.value; 
                } else {
                    otherPositionWrapper.classList.add('hidden');
                    otherPositionText.required = false;
                }
            }

            // Jalankan saat halaman dimuat
            toggleOtherPosition(); 

            // Tambahkan event listener ke semua radio button
            radioButtons.forEach(radio => {
                radio.addEventListener('change', toggleOtherPosition);
            });

            // Saat pengguna mengetik di kolom "Lainnya"
            otherPositionText.addEventListener('input', function() {
                // Update value dari radio button "Lainnya" secara real-time
                if (lainnyaRadio.checked) {
                    lainnyaRadio.value = this.value;
                }
            });


            // Saat form disubmit
            const form = document.getElementById('attendance-form');
            form.addEventListener('submit', function (event) {
                // Cek Tanda Tangan
                if (signaturePad.isEmpty()) {
                    alert("Tanda tangan tidak boleh kosong.");
                    event.preventDefault();
                } else {
                    const signatureDataInput = document.getElementById('signature-data');
                    signatureDataInput.value = signaturePad.toDataURL('image/png');
                }

                // Final check untuk value 'Lainnya'
                if (lainnyaRadio.checked && !otherPositionText.value) {
                    alert("Silakan isi jabatan/unit Anda.");
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>