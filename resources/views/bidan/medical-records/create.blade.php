@extends('layouts.app')

@section('header', 'Tambah Rekam Medis')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4 border border-red-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('medical-records.store') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

            <!-- Patient Info Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pasien</h3>
                </div>
                <div class="px-4 py-5 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Read-only Data -->
                    <div class="bg-blue-50 p-4 rounded-md border border-blue-100 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-blue-800 uppercase">Nama Pasien</label>
                            <p class="text-base font-semibold text-gray-900">{{ $pasien->nama_pasien }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-blue-800 uppercase">Usia</label>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-blue-800 uppercase">Alamat</label>
                            <p class="text-sm text-gray-900">{{ $pasien->alamat }}</p>
                        </div>
                    </div>

                    <!-- Editable Allergy -->
                    <div class="space-y-2">
                        <label for="alergi" class="block text-sm font-medium text-red-600 uppercase">Alergi (Dapat
                            diupdate)</label>
                        <textarea id="alergi" name="alergi" rows="4"
                            class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2 bg-red-50 text-gray-900"
                            placeholder="Tidak ada">{{ old('alergi', $pasien->alergi ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Subjective Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200 mt-6">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Keluhan Utama (Subjective)</h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <label for="keluhan_utama" class="sr-only">Keluhan Utama</label>
                    <textarea id="keluhan_utama" name="keluhan_utama" rows="3" required
                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"
                        placeholder="Contoh: Panas demam sudah 3 hari, disertai pusing.">{{ old('keluhan_utama') }}</textarea>
                </div>
            </div>

            <!-- Objective Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200 mt-6">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Pemeriksaan Fisik (Objective)</h3>
                </div>
                <div class="px-4 py-5 sm:px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label for="tekanan_darah" class="block text-sm font-medium text-slate-700">Tekanan Darah
                            (mmHg)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="tekanan_darah" id="tekanan_darah" value="{{ old('tekanan_darah') }}"
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                placeholder="120/80">
                        </div>
                    </div>
                    <div>
                        <label for="nadi" class="block text-sm font-medium text-slate-700">Nadi (x/mnt)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="nadi" id="nadi" value="{{ old('nadi') }}"
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                placeholder="80">
                        </div>
                    </div>
                    <div>
                        <label for="frekuensi_pernapasan" class="block text-sm font-medium text-slate-700">Pernapasan
                            (x/mnt)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="frekuensi_pernapasan" id="frekuensi_pernapasan"
                                value="{{ old('frekuensi_pernapasan') }}"
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                placeholder="20">
                        </div>
                    </div>
                    <div>
                        <label for="suhu_tubuh" class="block text-sm font-medium text-slate-700">Suhu Tubuh (°C)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh"
                                value="{{ old('suhu_tubuh') }}"
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                placeholder="36.5">
                        </div>
                    </div>
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-slate-700">Berat Badan (kg)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}"
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                placeholder="60">
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-2 lg:col-span-4">
                        <label for="pemeriksaan_fisik" class="block text-sm font-medium text-slate-700">Catatan Pemeriksaan
                            Fisik Lainnya</label>
                        <div class="mt-1">
                            <textarea id="pemeriksaan_fisik" name="pemeriksaan_fisik" rows="3"
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2"
                                placeholder="Catatan tambahan...">{{ old('pemeriksaan_fisik') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200 mt-6">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Diagnosis (Assessment)</h3>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <label for="diagnosis" class="sr-only">Diagnosis</label>
                    <input type="text" name="diagnosis" id="diagnosis" required value="{{ old('diagnosis') }}"
                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                        placeholder="Diagnosa Medis">
                </div>
            </div>

            <!-- Plan Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200 mt-6">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tindakan & Pengobatan (Plan)</h3>
                </div>
                <div class="px-4 py-5 sm:px-6 space-y-6">
                    <div>
                        <label for="tindakan" class="block text-sm font-medium text-slate-700 mb-1">Tindakan /
                            Terapi</label>
                        <textarea id="tindakan" name="tindakan" rows="3" required
                            class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2">{{ old('tindakan') }}</textarea>
                    </div>

                    <!-- Medicines -->
                    <div class="border-t border-gray-100 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-medium text-slate-700">Resep Obat</label>
                            <button type="button" id="add-medicine-btn"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-sm transition-colors duration-150">
                                <svg class="mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Tambah Obat
                            </button>
                        </div>
                        <div id="prescription-container" class="space-y-3">
                            <!-- Dynamic rows will be added here -->
                        </div>
                        <p class="mt-2 text-xs text-slate-500 italic">Klik tombol "Tambah Obat" untuk menambahkan resep.</p>
                    </div>

                    <!-- Layanan & Biaya -->
                    <div class="border-t border-gray-100 pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="layanan_id" class="block text-sm font-medium text-slate-700 mb-1">Layanan
                                Klinik</label>
                            <select id="layanan_id" name="layanan_id" required
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ old('layanan_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="biaya" class="block text-sm font-medium text-slate-700 mb-1">Biaya (Rp)</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="biaya" id="biaya" required value="{{ old('biaya') }}"
                                    class="focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md p-2 border"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ url()->previous() }}"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Simpan Rekam Medis
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('prescription-container');
            const addBtn = document.getElementById('add-medicine-btn');
            const medicines = @json($medicines);

            const oldObatIds = @json(old('obat_id', []));
            const oldJumlahs = @json(old('jumlah', []));
            const oldDoses = @json(old('dosis', []));

            function addRow(data = null) {
                const row = document.createElement('div');
                row.className = 'grid grid-cols-12 gap-4 items-end bg-gray-50 p-3 rounded-lg border border-gray-200 transition-all duration-200 hover:shadow-sm';

                let options = '<option value="">Pilih Obat</option>';
                medicines.forEach(m => {
                    let selected = (data && data.id == m.id) ? 'selected' : '';
                    options += `<option value="${m.id}" ${selected}>${m.nama_obat} (Stok: ${m.stok} ${m.satuan || ''})</option>`;
                });

                const jumlahValue = data ? data.jumlah : '';
                const dosisValue = data ? data.dosis : '';

                row.innerHTML = `
                                        <div class="col-span-5 relative">
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Nama Obat</label>
                                            <select name="obat_id[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-2 border" required>
                                                ${options}
                                            </select>
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Jumlah</label>
                                            <input type="number" name="jumlah[]" value="${jumlahValue}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-2 border" min="1" required>
                                        </div>
                                        <div class="col-span-4">
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Dosis</label>
                                            <input type="text" name="dosis[]" value="${dosisValue}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-2 border" placeholder="3x1" required>
                                        </div>
                                        <div class="col-span-1 flex justify-center pb-1">
                                             <button type="button" class="remove-row-btn text-red-500 hover:text-red-700 focus:outline-none transition-colors duration-150 p-1 rounded-full hover:bg-red-50">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    `;
                container.appendChild(row);

                row.querySelector('.remove-row-btn').addEventListener('click', function () {
                    row.remove();
                });
            }

            addBtn.addEventListener('click', () => addRow());

            // Initialize rows with old data if available
            if (oldObatIds.length > 0) {
                oldObatIds.forEach((id, index) => {
                    addRow({
                        id: id,
                        jumlah: oldJumlahs[index] || '',
                        dosis: oldDoses[index] || ''
                    });
                });
            } else {
                // Do not add default row to allow submission without medicine
            }
        });
    </script>
@endsection