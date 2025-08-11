<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Tambahkan use statement ini

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::latest()->paginate(10);
        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('admin.meetings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_date' => 'required|date',
        ]);
        $validated['slug'] = Str::slug($validated['title'] . '-' . now()->timestamp);
        Meeting::create($validated);
        return redirect()->route('meetings.index')->with('success', 'Agenda rapat baru berhasil ditambahkan.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load('attendances');
        return view('admin.meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_date' => 'required|date',
        ]);
        $validated['slug'] = Str::slug($validated['title'] . '-' . now()->timestamp);
        $meeting->update($validated);
        return redirect()->route('meetings.index')->with('success', 'Agenda rapat berhasil diperbarui.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'Agenda rapat berhasil dihapus.');
    }

    // FUNGSI BARU UNTUK DOWNLOAD PDF
    public function downloadPdf(Meeting $meeting)
    {
        $meeting->load('attendances');
        $pdf = Pdf::loadView('pdf.attendance_report', compact('meeting'));
        return $pdf->download('laporan-absensi-' . $meeting->slug . '.pdf');
    }
}