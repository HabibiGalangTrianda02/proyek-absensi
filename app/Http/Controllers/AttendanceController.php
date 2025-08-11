<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Menampilkan form absensi untuk meeting tertentu.
     */
    public function create(Meeting $meeting)
    {
        // Menyimpan slug meeting untuk digunakan saat redirect
        session(['meeting_slug' => $meeting->slug]);
        return view('attendance_form', compact('meeting'));
    }

    /**
     * Menyimpan data absensi baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $validated = $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'signature' => 'required|string', // Validasi bahwa tanda tangan tidak kosong
        ]);

        // 2. Simpan ke database
        Attendance::create($validated);
        
        // 3. Ambil slug dari session untuk redirect
        $meetingSlug = session('meeting_slug');

        // 4. Redirect kembali ke halaman form dengan pesan sukses
        return redirect()->route('attendance.create', $meetingSlug)
                         ->with('success', 'Terima kasih, absensi Anda telah berhasil dicatat.');
    }
}