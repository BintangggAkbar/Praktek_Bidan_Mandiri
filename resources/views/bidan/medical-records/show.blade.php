@extends('layouts.app')

@section('header', 'Detail Rekam Medis')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Patient & Bidan Info Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pasien & Pemeriksa</h3>
            </div>
            <div class="px-4 py-5 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data Pasien -->
                <div class="bg-blue-50 p-4 rounded-md border border-blue-100">
                    <h4 class="text-sm font-medium text-blue-800 uppercase tracking-wider mb-3">Data Pasien</h4>
                    <div class="space-y-1">
                        <p class="text-base font-semibold text-gray-900">{{ $medicalRecord->pasien->nama_pasien ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Usia: {{ \Carbon\Carbon::parse($medicalRecord->pasien->tanggal_lahir)->age }} Tahun</p>
                        <p class="text-sm text-gray-600">{{ $medicalRecord->pasien->alamat ?? '-' }}</p>
                        <p class="text-sm text-red-600 font-medium">Alergi: {{ $medicalRecord->pasien->alergi ?? '-' }}</p>
                    </div>
                </div>

                <!-- Diperiksa Oleh -->
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Diperiksa Oleh</h4>
                    <div class="space-y-1">
                        <p class="text-base font-semibold text-gray-900">{{ $medicalRecord->bidan->nama_lengkap ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Layanan: <span class="font-medium">{{ $medicalRecord->layanan->nama_layanan ?? '-' }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Examination Details Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center bg-gray-50 border-b border-gray-200">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pemeriksaan</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Waktu Periksa: {{ $medicalRecord->created_at->format('d F Y, H:i') }}
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <!-- Subjective -->
                    <div class="sm:col-span-2 space-y-4">
                        <div class="border-b border-gray-100 pb-2">
                            <h4 class="text-base font-semibold text-primary-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                Keluhan Utama (Subjective)
                            </h4>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-900">
                            {{ $medicalRecord->keluhan_utama }}
                        </div>
                    </div>

                    <!-- Objective -->
                    <div class="sm:col-span-2 space-y-4 pt-4">
                         <div class="border-b border-gray-100 pb-2">
                            <h4 class="text-base font-semibold text-primary-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Pemeriksaan Fisik (Objective)
                            </h4>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-3 rounded-md text-center">
                                <span class="block text-xs text-blue-600 font-medium">Tekanan Darah</span>
                                <span class="block text-lg font-bold text-gray-900">{{ $medicalRecord->tekanan_darah }} <span class="text-xs font-normal text-gray-500">mmHg</span></span>
                            </div>
                            <div class="bg-green-50 p-3 rounded-md text-center">
                                <span class="block text-xs text-green-600 font-medium">Nadi</span>
                                <span class="block text-lg font-bold text-gray-900">{{ $medicalRecord->nadi }} <span class="text-xs font-normal text-gray-500">x/mnt</span></span>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-md text-center">
                                <span class="block text-xs text-purple-600 font-medium">Pernapasan</span>
                                <span class="block text-lg font-bold text-gray-900">{{ $medicalRecord->frekuensi_pernapasan }} <span class="text-xs font-normal text-gray-500">x/mnt</span></span>
                            </div>
                            <div class="bg-orange-50 p-3 rounded-md text-center">
                                <span class="block text-xs text-orange-600 font-medium">Suhu</span>
                                <span class="block text-lg font-bold text-gray-900">{{ $medicalRecord->suhu_tubuh }} <span class="text-xs font-normal text-gray-500">°C</span></span>
                            </div>
                             <div class="bg-yellow-50 p-3 rounded-md text-center col-span-2 sm:col-span-4">
                                <span class="block text-xs text-yellow-600 font-medium">Berat Badan</span>
                                <span class="block text-lg font-bold text-gray-900">{{ $medicalRecord->berat_badan }} <span class="text-xs font-normal text-gray-500">kg</span></span>
                            </div>
                        </div>

                        @if($medicalRecord->pemeriksaan_fisik)
                        <div class="mt-2">
                             <dt class="text-sm font-medium text-gray-500 mb-1">Catatan Tambahan:</dt>
                             <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $medicalRecord->pemeriksaan_fisik }}</dd>
                        </div>
                        @endif
                    </div>

                    <!-- Assessment -->
                    <div class="sm:col-span-2 space-y-4 pt-4">
                         <div class="border-b border-gray-100 pb-2">
                            <h4 class="text-base font-semibold text-primary-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Diagnosis (Assessment)
                            </h4>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md text-sm text-gray-900 font-medium">
                            {{ $medicalRecord->diagnosis }}
                        </div>
                    </div>

                    <!-- Plan -->
                    <div class="sm:col-span-2 space-y-4 pt-4">
                         <div class="border-b border-gray-100 pb-2">
                             <h4 class="text-base font-semibold text-primary-700 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                Tindakan & Pengobatan (Plan)
                            </h4>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-1">Tindakan:</dt>
                                <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $medicalRecord->tindakan }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Resep Obat:</dt>
                                @if($medicalRecord->medicines->count() > 0)
                                    <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosis</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($medicalRecord->medicines as $medicine)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $medicine->nama_obat }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $medicine->pivot->jumlah }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $medicine->pivot->dosis }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif($medicalRecord->resep_obat)
                                     <!-- Fallback for old simple text recipe if exists -->
                                     <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $medicalRecord->resep_obat }}</dd>
                                @else
                                    <p class="text-sm text-gray-500 italic">Tidak ada resep obat.</p>
                                @endif
                            </div>

                             <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center sm:w-1/2 ml-auto">
                                <span class="text-base font-medium text-gray-700">Total Biaya:</span>
                                <span class="text-xl font-bold text-primary-700">Rp {{ number_format($medicalRecord->biaya, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </dl>
            </div>
            
            <div class="px-4 py-4 sm:px-6 bg-gray-50 text-right">
                <a href="{{ url()->previous() }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection