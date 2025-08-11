<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar agenda rapat.
     */
    public function index()
    {
        // Ambil semua data rapat, urutkan berdasarkan tanggal terbaru
        $meetings = Meeting::orderBy('meeting_date', 'desc')->paginate(10);
        
        // Kirim data ke view baru yang akan kita buat
        return view('public.meetings.index', compact('meetings'));
    }
}