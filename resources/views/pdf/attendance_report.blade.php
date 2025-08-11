<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Rapat</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; font-size: 12px; vertical-align: middle;}
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px;}
        .header p { margin: 0; font-size: 14px; }
        .signature-img { width: 100px; height: auto; }
    </style>
</head>
<body>

    <div class="header">
        <h1>DAFTAR HADIR RAPAT</h1>
        <p>{{ strtoupper($meeting->title) }}</p>
        <p>TANGGAL: {{ \Carbon\Carbon::parse($meeting->meeting_date)->isoFormat('D MMMM YYYY') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Jabatan/Unit</th>
                <th style="width: 20%;">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($meeting->attendances as $index => $attendance)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $attendance->name }}</td>
                    <td>{{ $attendance->nik }}</td>
                    <td>{{ $attendance->position }}</td>
                    <td style="text-align: center;">
                        @if($attendance->signature)
                            <img src="{{ $attendance->signature }}" alt="Tanda Tangan" class="signature-img">
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada peserta yang mengisi absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>