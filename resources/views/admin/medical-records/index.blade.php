@extends('layouts.admin')

@section('header', 'Data Rekam Medis')

@section('content')
    <!-- Search -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="w-full sm:w-1/2 lg:w-1/3">
            <form action="{{ route('admin.medical-records.index') }}" method="GET">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <!-- Heroicon name: solid/search -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search"
                        class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md p-2 border"
                        placeholder="Cari nama pasien atau bidan..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pasien
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bidan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Layanan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Keluhan Utama
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($medicalRecords as $record)
                    <tr class="hover:bg-gray-50 cursor-pointer"
                        onclick="window.location='{{ route('admin.medical-records.show', $record) }}'">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $record->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $record->pasien->nama_pasien ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->bidan->nama_lengkap ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->layanan->nama_layanan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                            {{ Str::limit($record->keluhan_utama, 50) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data rekam medis.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($medicalRecords->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $medicalRecords->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- Debounce Script -->
    <script>
        let timeout = null;
        const searchInput = document.getElementById('search');

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                searchInput.closest('form').submit();
            }, 500);
        });

        // Focus on input if it has value (after reload)
        if (searchInput.value) {
            searchInput.focus();
            // Move cursor to end
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }
    </script>
@endsection