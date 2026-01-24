@extends('layouts.admin')

@section('header', 'Data Pasien')

@section('content')
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between gap-4 items-center">
            <!-- Search -->
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <!-- Note: Using 'q' or 'search' parameter as per controller implementation -->
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border"
                    placeholder="Cari nama pasien...">
            </div>

            <!-- No Add Button (View Only) -->
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID
                            Pasien
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama
                            Pasien</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Alergi
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tgl
                            Lahir</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Umur
                            (Thn)</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Umur
                            (Bln)</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Umur
                            (Hr)</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Alamat
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-500">
                                P-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xs mr-3 border border-primary-200">
                                        {{ strtoupper(substr($patient->nama_pasien, 0, 2)) }}
                                    </div>
                                    <div class="text-sm font-medium text-slate-900">{{ $patient->nama_pasien }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                @if($patient->alergi)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $patient->alergi }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $patient->age_detailed['years'] }} Th
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $patient->age_detailed['months'] }} Bln
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $patient->age_detailed['days'] }} Hr
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 truncate max-w-xs"
                                title="{{ $patient->alamat }}">
                                {{ Str::limit($patient->alamat, 30) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-500">
                                Belum ada data pasien.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $patients->withQueryString()->links() }}
        </div>
    </div>
    <script>
        let timeout = null;
        document.getElementById('search').addEventListener('input', function (e) {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                let query = e.target.value;
                let url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.set('page', 1); // Reset to page 1
                window.location.href = url.toString();
            }, 500); // 500ms debounce
        });

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('search') && searchInput) {
                searchInput.focus();
                // Move cursor to end
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        });
    </script>
@endsection