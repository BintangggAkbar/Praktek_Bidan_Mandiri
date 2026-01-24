@extends('layouts.admin')

@section('header', 'Edit Layanan')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('admin.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <!-- Nama Layanan -->
                    <div>
                        <label for="nama_layanan" class="block text-sm font-medium text-slate-700">Nama Layanan</label>
                        <div class="mt-1">
                            <input type="text" name="nama_layanan" id="nama_layanan" required
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                value="{{ old('nama_layanan', $service->nama_layanan) }}">
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
                                class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                        </div>
                         @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                     <!-- Status -->
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="status" name="status" type="checkbox" value="1"
                                class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                {{ old('status', $service->status) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="status" class="font-medium text-slate-700">Status Aktif</label>
                            <p class="text-slate-500">Centang jika layanan ini tersedia untuk pasien.</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 text-right sm:px-6 flex justify-end gap-3">
                    <a href="{{ route('admin.services.index') }}"
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
