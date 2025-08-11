<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Rapat: {{ $meeting->title }}
            </h2>
            <a href="{{ route('meetings.download', $meeting->id) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Daftar Hadir</h3>
                    <p class="mb-4">Tanggal: {{ \Carbon\Carbon::parse($meeting->meeting_date)->isoFormat('D MMMM YYYY') }}</p>

                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan/Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanda Tangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Absen</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($meeting->attendances as $index => $attendance)
                                <tr>
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">{{ $attendance->name }}</td>
                                    <td class="px-6 py-4">{{ $attendance->nik }}</td>
                                    
                                    <td class="px-6 py-4">{{ $attendance->position }}</td>
                                    
                                    <td class="px-6 py-4">
                                        <img src="{{ $attendance->signature }}" alt="Tanda Tangan" class="h-12 border">
                                    </td>
                                    <td class="px-6 py-4">{{ $attendance->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada peserta yang mengisi absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>