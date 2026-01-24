@extends('layouts.admin')

@section('header', 'Laporan Klinik')

@section('content')
    <div class="space-y-6">
        <!-- Filters -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-medium leading-6 text-slate-900 mb-4">Filter Laporan</h3>
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                    <!-- Jenis Laporan -->
                    <div class="sm:col-span-4">
                        <label for="type" class="block text-sm font-medium text-slate-700">Jenis Laporan</label>
                        <select id="type" name="type"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md border">
                            <option value="kunjungan" {{ request('type') == 'kunjungan' ? 'selected' : '' }}>Laporan Kunjungan Pasien</option>
                            <option value="penyakit" {{ request('type') == 'penyakit' ? 'selected' : '' }}>Rekap Kasus Penyakit</option>
                            <option value="obat" {{ request('type') == 'obat' ? 'selected' : '' }}>Laporan Penggunaan Obat</option>
                            <option value="keuangan" {{ request('type') == 'keuangan' ? 'selected' : '' }}>Laporan Pendapatan</option>
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="sm:col-span-3">
                        <label for="start_date" class="block text-sm font-medium text-slate-700">Dari Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}"
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                        </div>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="sm:col-span-3">
                        <label for="end_date" class="block text-sm font-medium text-slate-700">Sampai Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}"
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <div class="sm:col-span-2 flex items-end">
                        <button type="submit"
                            class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
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
                <!-- Header Laporan -->
                <div class="mb-6 border-b pb-4 flex flex-col sm:flex-row justify-between items-end gap-4">
                    <div class="text-center sm:text-left w-full sm:w-auto">
                        <h2 class="text-xl font-bold text-gray-800 uppercase">
                            @switch($type)
                                @case('kunjungan') Laporan Kunjungan Pasien @break
                                @case('penyakit') Rekap Kasus Penyakit @break
                                @case('obat') Laporan Penggunaan Obat @break
                                @case('keuangan') Laporan Pendapatan Klinik @break
                            @endswitch
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">
                            Periode: {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto justify-end">
                        <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Export PDF
                        </a>
                        <a href="{{ route('admin.reports.excel', request()->all()) }}" target="_blank"
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

                <!-- Content Table -->
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
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Stok Saat Ini</th>
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
                   @elseif($type === 'keuangan')
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kunjungan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $totalIncome = 0; @endphp
                                @foreach($data as $item)
                                @php $totalIncome += $item->revenue; @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->total_visits }} Kunjungan</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($item->revenue, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50 font-bold">
                                    <td colspan="2" class="px-6 py-4 text-right text-gray-900">Grand Total</td>
                                    <td class="px-6 py-4 text-right text-green-700">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                                </tr>
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
                <p class="mt-1 text-sm text-gray-500">Tidak ada data laporan untuk periode atau filter yang dipilih.</p>
            </div>
        @endif
    </div>
@endsection