@extends('layouts.admin')

@section('header', 'Edit Data Bidan')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('admin.bidans.update', $bidan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Nama -->
                        <div class="sm:col-span-6">
                            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                            <div class="mt-1">
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                    value="{{ old('nama_lengkap', $bidan->nama_lengkap) }}" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border @error('nama_lengkap') border-red-500 @enderror">
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-6">
                            <label for="status" class="block text-sm font-medium text-slate-700">Status Bidan</label>
                            <div class="mt-1">
                                <select id="status" name="status" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                    <option value="aktif" {{ old('status', $bidan->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="nonaktif" {{ old('status', $bidan->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="sm:col-span-3">
                            <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                            <div class="mt-1">
                                <input type="text" name="username" id="username"
                                    value="{{ old('username', $bidan->username) }}" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border @error('username') border-red-500 @enderror">
                                @error('username')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email" value="{{ old('email', $bidan->email) }}"
                                    required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- No HP -->
                        <div class="sm:col-span-3">
                            <label for="no_hp" class="block text-sm font-medium text-slate-700">No. HP</label>
                            <div class="mt-1">
                                <input type="text" name="no_hp" id="no_hp" required
                                    value="{{ old('no_hp', $bidan->no_hp) }}"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border @error('no_hp') border-red-500 @enderror">
                                @error('no_hp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="sm:col-span-6">
                            <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat</label>
                            <div class="mt-1">
                                <textarea id="alamat" name="alamat" rows="3" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border border-gray-300 rounded-md p-2 @error('alamat') border-red-500 @enderror">{{ old('alamat', $bidan->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Divider untuk Reset Password -->
                        <div class="sm:col-span-6 border-t border-gray-200 pt-4 mt-2">
                            <h3 class="text-sm font-medium text-slate-800">Reset Password</h3>
                            <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <!-- Password Baru -->
                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-slate-700">Password Baru</label>
                            <div class="mt-1">
                                <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="sm:col-span-3">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi
                                Password</label>
                            <div class="mt-1">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
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