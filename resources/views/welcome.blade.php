@extends('layouts.guest')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Layanan Kesehatan 1</span>
                            <span class="block text-primary-600 xl:inline">Terpercaya untuk Ibu & Anak</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Melati Ika menyediakan layanan kesehatan bagi ibu dan anak dengan pendekatan yang ramah dan
                            profesional.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#services"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 md:py-4 md:text-lg md:px-10">
                                    Lihat Layanan
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="#schedule"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 md:py-4 md:text-lg md:px-10">
                                    Jadwal Buka
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-primary-50 flex items-center justify-center">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo Melati Ika" class="
                        w-48
                        sm:w-64
                        md:w-80
                        lg:w-[420px]
                        xl:w-[480px]
                        object-contain
                    ">
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Layanan Kami</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Solusi Kesehatan Lengkap
                </p>
                <p class="mt-4 max-w-2xl text-xl text-slate-500 lg:mx-auto">
                    Kami menyediakan berbagai layanan kesehatan untuk memenuhi kebutuhan Anda dan keluarga.
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-2">
                @foreach($services as $service)
                    <div class="relative flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <dt>
                                <p class="text-lg leading-6 font-medium text-slate-900">{{ $service->nama_layanan }}</p>
                            </dt>
                            <dd class="mt-2 text-base text-slate-500">
                                {{ $service->deskripsi }}
                            </dd>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Schedule Info -->
    <div id="schedule" class="bg-primary-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Jam Buka</span>
                <span class="block text-primary-200 text-lg font-medium mt-2">Kunjungi kami di waktu operasional
                    berikut:</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow p-6 bg-white text-slate-900 flex-col gap-2">
                    @foreach($schedules as $schedule)
                        <div class="flex justify-between w-64 border-b border-gray-100 pb-2 last:border-0">
                            <span class="font-medium">{{ $schedule->hari }}</span>
                            @if($schedule->status)
                                <span class="text-slate-600">{{ \Carbon\Carbon::parse($schedule->jam_buka)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->jam_tutup)->format('H:i') }}</span>
                            @else
                                <span class="text-red-500 font-medium">Tutup</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection