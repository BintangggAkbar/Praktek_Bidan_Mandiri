<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') | Melati Ika
        @elseif(View::hasSection('header'))
            @yield('header') | Melati Ika
        @else
            Melati Ika
        @endif
    </title>

    <!-- Local Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="icon" type="image/webp" href="{{ asset('gambar/logo.webp') }}">

    <!-- Scripts -->
    <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>

</head>

<body class="font-sans antialiased bg-gray-50 text-slate-800">
    <div x-data="{ sidebarOpen: false, profileOpen: false }"
        class="h-screen overflow-hidden flex flex-col md:flex-row relative">

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80 z-30 md:hidden" style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="w-64 bg-gradient-to-b from-emerald-500 to-teal-600 border-none flex flex-col h-screen fixed inset-y-0 left-0 z-40 transition-transform duration-300 ease-in-out md:translate-x-0 md:relative md:inset-auto md:flex text-white">
            <div class="h-16 border-b border-white/10">
                <a href="{{ route('dashboard') }}"
                    class="h-full px-4 flex items-center gap-3 font-bold text-xl text-white hover:bg-white/10 transition">
                    <img src="{{ asset('gambar/logo.webp') }}" alt="Logo Melati Ika" class="h-16 w-auto object-contain">
                    <span>Melati Ika</span>
                </a>
            </div>


            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Pasien -->
                    <li>
                        <a href="{{ route('patients.index') }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Data Pasien
                        </a>
                    </li>

                    <!-- Rekam Medis Terakhir -->
                    <li>
                        <a href="{{ route('medical-records.latest') }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('medical-records.latest') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Riwayat Medis
                        </a>
                    </li>

                    <!-- Jadwal -->
                    <li>
                        <a href="{{ route('bidan.schedule.index') }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('bidan.schedule.index') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0h18M5 10.5h.008v.008H5V10.5Zm0 3h.008v.008H5V13.5Zm0 3h.008v.008H5V16.5Zm3-6h.008v.008H8V10.5Zm0 3h.008v.008H8V13.5Zm0 3h.008v.008H8V16.5Zm3-6h.008v.008H11V10.5Zm0 3h.008v.008H11V13.5Zm0 3h.008v.008H11V16.5Zm3-6h.008v.008H14V10.5Zm0 3h.008v.008H14V13.5Zm0 3h.008v.008H14V16.5Z" />
                            </svg>
                            Jadwal Buka
                        </a>
                    </li>

                    <!-- Obat -->
                    <li>
                        <a href="{{ route('medicines.index') }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('medicines.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                            </svg>
                            Data Obat
                        </a>
                    </li>

                    <!-- Laporan -->
                    <li>
                        <a href="{{ route('reports.index') }}" @click="sidebarOpen = false"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.index') ? 'bg-white/20 text-white font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Laporan
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-red-100 hover:bg-red-500/20 hover:text-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Header -->
            <header
                class="h-16 bg-gradient-to-r from-emerald-500 to-teal-600 border-none flex items-center justify-between px-6 shadow-sm">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <h1 class="text-xl font-semibold text-white">
                    @yield('header', 'Dashboard')
                </h1>

                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-end">
                        <span class="text-sm font-medium text-white">{{ Auth::user()->nama_lengkap }}</span>
                        <span class="text-xs text-white/80">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen"
                            class="h-10 w-10 rounded-full bg-white flex items-center justify-center text-teal-600 font-bold shadow-sm hover:ring-2 hover:ring-white/50 transition-all cursor-pointer">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 2)) }}
                        </button>
                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" @click.away="profileOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                            style="display: none;">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                Edit Profil
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @if(session('success'))
                    <div
                        class="mb-4 p-4 rounded-md bg-green-50 text-green-700 border border-green-200 flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="mb-4 p-4 rounded-md bg-red-50 text-red-700 border border-red-200 flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>