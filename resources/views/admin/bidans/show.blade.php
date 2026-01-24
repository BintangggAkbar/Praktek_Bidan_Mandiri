@extends('layouts.admin')

@section('header', 'Detail Data Bidan')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-slate-900">Informasi Bidan</h3>
                    <p class="mt-1 max-w-2xl text-sm text-slate-500">Detail data pribadi dan akun.</p>
                </div>
                <a href="{{ route('admin.bidans.edit', $bidan) }}"
                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Edit
                </a>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $bidan->nama_lengkap }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">Username</dt>
                        <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $bidan->username }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $bidan->email }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">No. HP</dt>
                        <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $bidan->no_hp ?? '-' }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">Alamat</dt>
                        <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">{{ $bidan->alamat ?? '-' }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">Status Akun</dt>
                        @if ($bidan->status == 'aktif')
                            <span
                                class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Nonaktif
                            </span>
                        @endif
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-slate-500">Bergabung Sejak</dt>
                        <dd class="mt-1 text-sm text-slate-900 sm:mt-0 sm:col-span-2">
                            {{ $bidan->created_at->format('d M Y') }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="px-4 py-4 sm:px-6 bg-gray-50 text-right">
                <a href="{{ route('admin.bidans.index') }}"
                    class="text-sm font-medium text-primary-600 hover:text-primary-500">
                    &larr; Kembali
                </a>
            </div>
        </div>
    </div>
@endsection