@extends('layouts.app')

@section('header', 'Laporan')

@section('content')
    <div class="space-y-6">
        <!-- Filters -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <h3 class="text-sm font-medium text-slate-700 mb-4">Filter Laporan</h3>
            <form action="{{ route('reports.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                    <div>
                        <label for="type" class="block text-xs font-medium text-slate-500 uppercase">Jenis Laporan</label>
                        <select id="type" name="type"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md border">
                            <option value="kunjungan" {{ request('type') == 'kunjungan' ? 'selected' : '' }}>Kunjungan Pasien</option>
                            <option value="penyakit" {{ request('type') == 'penyakit' ? 'selected' : '' }}>Rekap Kasus Penyakit</option>
                            <option value="obat" {{ request('type') == 'obat' ? 'selected' : '' }}>Penggunaan Obat</option>
                            <option value="rekam_medis_saya" {{ request('type') == 'rekam_medis_saya' ? 'selected' : '' }}>Rekam Medis Saya</option>
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="block text-xs font-medium text-slate-500 uppercase">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}"
                            class="mt-1 shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-medium text-slate-500 uppercase">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}"
                            class="mt-1 shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Report Content -->
        @if(isset($data) && count($data) > 0)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden p-6">
                <!-- Header Laporan -->
                <div class="mb-6 border-b pb-4 flex flex-col sm:flex-row justify-between items-end gap-4">
                    <div class="text-center sm:text-left w-full sm:w-auto">
                        <h2 class="text-xl font-bold text-gray-800 uppercase">
                            @switch($type)
                                @case('kunjungan') Laporan Kunjungan Pasien @break
                                @case('penyakit') Rekap Kasus Penyakit @break
                                @case('obat') Laporan Penggunaan Obat @break
                                @case('rekam_medis_saya') Rekam Medis Saya @break
                            @endswitch
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">
                            Periode: {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto justify-end">
                         <a href="{{ route('reports.print', request()->all()) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Export PDF
                        </a>
                        <a href="{{ route('reports.excel', request()->all()) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Export Excel
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if($type === 'kunjungan')
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kunjungan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->total_visits }} Pasien</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $item->nama_layanan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($type === 'penyakit')
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa Penyakit</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kasus</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $item->diagnosis }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $item->count }} Kasus</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($type === 'obat')
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Terpakai</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $item->nama_obat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $item->total_used }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $item->stok }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($type === 'rekam_medis_saya')
                         <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosa</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->created_at->translatedFormat('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->pasien->nama_pasien }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->diagnosis }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-12 flex flex-col items-center justify-center text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Data Tidak Ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada data untuk filter yang dipilih.</p>
            </div>
        @endif
    </div>
@endsection