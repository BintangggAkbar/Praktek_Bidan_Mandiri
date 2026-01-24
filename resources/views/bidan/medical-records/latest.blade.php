@extends('layouts.app')

@section('header', 'Riwayat Rekam Medis Terakhir')

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
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                    class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md py-2 border"
                    placeholder="Cari pasien atau diagnosa...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pasien
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Keluhan
                            & Diagnosa</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanda
                            Vital</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tindakan
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Resep
                            Obat</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Total
                            Biaya</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                        <tr class="hover:bg-slate-50 cursor-pointer transition align-top"
                            onclick="window.location='{{ route('medical-records.show', $record) }}'">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                <div>{{ $record->pasien->nama_pasien ?? 'Unknown' }}</div>
                                <div class="text-xs text-slate-500">ID: {{ $record->pasien_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $record->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 max-w-xs">
                                <div class="font-medium text-slate-700">Keluhan:</div>
                                <div class="mb-1">{{ $record->keluhan_utama }}</div>
                                <div class="font-medium text-slate-700">Diagnosa:</div>
                                <div class="text-blue-600">{{ $record->diagnosis }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                <div>TD: {{ $record->tekanan_darah }} mmHg</div>
                                <div>BB: {{ $record->berat_badan }} Kg</div>
                                <div>Suhu: {{ $record->suhu_tubuh }} °C</div>
                                <div>Nadi: {{ $record->nadi }} bpm</div>
                                <div>RR: {{ $record->frekuensi_pernapasan }} /min</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 max-w-xs">
                                {{ $record->tindakan }}
                                @if($record->pemeriksaan_fisik)
                                    <div class="mt-1 text-xs text-slate-400 italic">Fisik: {{ $record->pemeriksaan_fisik }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                @if($record->medicines->count() > 0)
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($record->medicines as $obat)
                                            <li>
                                                <span class="font-medium">{{ $obat->nama_obat }}</span>
                                                <span class="text-xs text-slate-400">({{ $obat->pivot->jumlah }} {{ $obat->satuan }},
                                                    {{ $obat->pivot->dosis }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-slate-400 italic">Tidak ada resep</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-slate-900">
                                Rp {{ number_format($record->biaya, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-slate-900">
                                <form action="{{ route('medical-records.destroy', $record) }}" method="POST" class="inline"
                                    onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus rekam medis ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="event.stopPropagation()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500">
                                Belum ada rekam medis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $records->withQueryString()->links() }}
        </div>
    </div>

    <script>
        let timeout = null;
        document.getElementById('searchInput').addEventListener('input', function (e) {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                let query = e.target.value;
                let url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.set('page', 1);
                window.location.href = url.toString();
            }, 500);
        });

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
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