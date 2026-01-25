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

<body class="font-sans antialiased text-slate-800 bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="border-b border-gray-100 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center gap-2 font-bold text-xl text-primary-600">
                            <img src="{{ asset('gambar/logo.webp') }}" alt="Logo Melati Ika"
                                class="h-16 w-auto object-contain">
                            <span>Melati Ika</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md transition">Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md transition">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-slate-600 hover:text-primary-600 transition">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer class="bg-slate-50 border-t border-slate-100 py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-4 text-center text-slate-500 text-sm">
                &copy; {{ date('Y') }} Melati Ika. Melayani sepenuh hati.
            </div>
        </footer>
    </div>
</body>

</html>