@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', 'Edit Profil')
@section('header', 'Edit Profil')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Profile Information --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-slate-800">Informasi Profil</h2>
                <p class="text-sm text-slate-500">Perbarui informasi profil dan alamat email akun Anda.</p>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                            value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('nama_lengkap') border-red-500 @enderror">
                    </div>

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('username') border-red-500 @enderror">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-slate-700 mb-1">
                            No. Telepon
                        </label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('no_hp') border-red-500 @enderror">
                    </div>
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1">
                        Alamat
                    </label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-slate-800">Ubah Password</h2>
                <p class="text-sm text-slate-500">Pastikan akun Anda menggunakan password yang kuat untuk keamanan.</p>
            </div>
            <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Password Baru --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="Ulangi password baru"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-slate-800 text-white rounded-md hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-colors">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Account Info --}}
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div
                    class="h-16 w-16 rounded-full {{ Auth::user()->role === 'admin' ? 'bg-slate-800' : 'bg-green-600' }} flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">{{ $user->nama_lengkap }}</h3>
                    <p class="text-sm text-slate-500">{{ ucfirst($user->role) }} • Bergabung sejak
                        {{ $user->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection