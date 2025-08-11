<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi Rapat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/(PKU) Sultan Syarif Kasim II.png') }}" alt="Logo Injourney" class="block h-[95px] w-auto" />
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Admin Login</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6">Daftar Agenda Rapat</h2>
            
            <div class="bg-white shadow overflow-hidden rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse ($meetings as $meeting)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-semibold text-indigo-600 truncate">{{ $meeting->title }}</p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <a href="{{ route('attendance.create', $meeting->slug) }}" class="px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                            Isi Absensi
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.75 3a.75.75 0 01.75.75v.5h7V3.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V3.75A.75.75 0 015.75 3zM4.5 6.5A1.25 1.25 0 015.75 5.25h8.5a1.25 1.25 0 011.25 1.25v8.5a1.25 1.25 0 01-1.25 1.25h-8.5a1.25 1.25 0 01-1.25-1.25v-8.5z" clip-rule="evenodd" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($meeting->meeting_date)->isoFormat('dddd, D MMMM YYYY') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>
                            <div class="px-4 py-4 sm:px-6 text-center text-gray-500">
                                Belum ada agenda rapat yang dijadwalkan.
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-6">
                {{ $meetings->links() }}
            </div>

        </div>
    </main>

</body>
</html>