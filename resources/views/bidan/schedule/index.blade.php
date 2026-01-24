@extends('layouts.app')

@section('header', 'Jadwal Buka')

@section('content')
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm max-w-4xl mx-auto">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium leading-6 text-slate-900">Jadwal Praktik</h3>
            <p class="mt-1 text-sm text-slate-500">Berikut adalah jadwal operasional klinik saat ini.</p>
        </div>

        <div class="overflow-hidden">
            <ul role="list" class="divide-y divide-gray-200">
                @forelse($schedules as $schedule)
                    <li class="p-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-primary-600 truncate">
                                    {{ $schedule->hari }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500 flex items-center">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @if($schedule->status)
                                        {{ \Carbon\Carbon::parse($schedule->jam_buka)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->jam_tutup)->format('H:i') }}
                                    @else
                                        Tutup
                                    @endif
                                </p>
                            </div>
                            @if($schedule->status)
                                <div class="flex-shrink-0 ml-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Buka
                                    </span>
                                </div>
                            @else
                                <div class="flex-shrink-0 ml-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Tutup
                                    </span>
                                </div>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="p-6 text-center text-gray-500 text-sm">
                        Jadwal belum tersedia.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection