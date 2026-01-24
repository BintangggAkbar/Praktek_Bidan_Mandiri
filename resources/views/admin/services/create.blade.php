@extends('layouts.admin')

@section('header', 'Tambah Layanan Baru')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Nama Layanan -->
                    <div>
                        <label for="nama_layanan" class="block text-sm font-medium text-slate-700">Nama Layanan</label>
                        <div class="mt-1">
                            <input type="text" name="nama_layanan" id="nama_layanan" required
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                value="{{ old('nama_layanan') }}" placeholder="Contoh: Pemeriksaan Umum">
                        </div>
                        @error('nama_layanan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                        <div class="mt-1">
                            <textarea id="deskripsi" name="deskripsi" rows="3" required
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                placeholder="Jelaskan detail layanan...">{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 text-right sm:px-6 flex justify-end gap-3">
                    <a href="{{ route('admin.services.index') }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection