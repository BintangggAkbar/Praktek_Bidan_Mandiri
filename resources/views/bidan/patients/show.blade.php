@extends('layouts.app')

@section('header', 'Detail Pasien')

@section('content')
    <div class="space-y-6">
        <!-- Header Info & Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center">
                <div
                    class="h-16 w-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-2xl mr-4 border border-primary-200">
                    {{ strtoupper(substr($patient->nama_pasien, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">{{ $patient->nama_pasien }}</h2>
                    <p class="text-slate-500">
                        P-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }} •
                        {{ $patient->jenis_kelamin }} •
                        {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} Tahun
                    </p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('patients.edit', $patient) }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Edit Data
                </a>
                <a href="{{ route('medical-records.create', ['pasien_id' => $patient->id]) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Rekam Medis
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar Detail Pasien -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-slate-900">Informasi Pribadi</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                        <dl class="divide-y divide-gray-200">
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">TTL</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">
                                    {{ $patient->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d M Y') }}
                                </dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $patient->alamat }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">Kontak</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $patient->no_hp }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">Pekerjaan</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $patient->pekerjaan }}</dd>
                            </div>
                            <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">Riwayat Alergi</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">
                                    @if($patient->alergi)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $patient->alergi }}
                                        </span>
                                    @else
                                        Tidak ada
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Main Content: Rekam Medis History -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-slate-900">Riwayat Rekam Medis</h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                            Total: {{ $medicalRecords->total() }} Kunjungan
                        </span>
                    </div>

                    <ul class="divide-y divide-gray-200">
                        @forelse($medicalRecords as $record)
                            <li class="hover:bg-slate-50 cursor-pointer transition"
                                onclick="window.location='{{ route('medical-records.show', $record) }}'">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-primary-600 truncate">
                                            {{ Str::limit($record->keluhan_utama ?? 'Kunjungan Rutin', 50) }}
                                        </p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Selesai
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-slate-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Keluhan: {{ Str::limit($record->keluhan_utama, 60) }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-slate-500 sm:mt-0">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <p>
                                                {{ $record->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm text-slate-500">
                                        <span class="font-medium">Diagnosa:</span> {{ $record->diagnosis }} <br>
                                        <span class="font-medium">Tindakan:</span> {{ $record->tindakan }}
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>
                                <div class="px-4 py-10 text-center text-slate-500 text-sm">
                                    Belum ada riwayat rekam medis.
                                </div>
                            </li>
                        @endforelse
                    </ul>
                    @if($medicalRecords->hasPages())
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            {{ $medicalRecords->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection