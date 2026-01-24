@extends('layouts.app')

@section('header', 'Edit Data Pasien')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <!-- Data Pribadi -->
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-slate-900 border-b border-gray-100 pb-2 mb-4">Data
                            Pribadi Pasien</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="nama_pasien" class="block text-sm font-medium text-slate-700">Nama
                                    Lengkap</label>
                                <div class="mt-1">
                                    <input type="text" name="nama_pasien" id="nama_pasien"
                                        value="{{ old('nama_pasien', $patient->nama_pasien) }}" required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700">Jenis
                                    Kelamin</label>
                                <div class="mt-1">
                                    <select id="jenis_kelamin" name="jenis_kelamin"
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                        <option value="Perempuan" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="tempat_lahir" class="block text-sm font-medium text-slate-700">Tempat
                                    Lahir</label>
                                <div class="mt-1">
                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                        value="{{ old('tempat_lahir', $patient->tempat_lahir) }}" required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700">Tanggal
                                    Lahir</label>
                                <div class="mt-1">
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $patient->tanggal_lahir) }}" required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                                <div class="mt-1">
                                    <textarea id="alamat" name="alamat" rows="3" required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2">{{ old('alamat', $patient->alamat) }}</textarea>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="no_hp" class="block text-sm font-medium text-slate-700">No. Telepon /
                                    WhatsApp</label>
                                <div class="mt-1">
                                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $patient->no_hp) }}"
                                        required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="pekerjaan" class="block text-sm font-medium text-slate-700">Pekerjaan</label>
                                <div class="mt-1">
                                    <input type="text" name="pekerjaan" id="pekerjaan"
                                        value="{{ old('pekerjaan', $patient->pekerjaan) }}" required
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>
                            <div class="sm:col-span-6">
                                <label for="alergi" class="block text-sm font-medium text-slate-700">Riwayat Alergi
                                    (Opsional)</label>
                                <div class="mt-1">
                                    <input type="text" name="alergi" id="alergi"
                                        value="{{ old('alergi', $patient->alergi) }}"
                                        class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                        placeholder="Contoh: Antibiotik, Kacang, Debu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 text-right sm:px-6 flex justify-end gap-3">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection