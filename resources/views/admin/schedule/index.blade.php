@extends('layouts.admin')

@section('header', 'Jadwal Buka & Tutup Klinik')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium leading-6 text-slate-900">Pengaturan Jam Operasional</h3>
                <p class="mt-1 text-sm text-slate-500">Atur jadwal buka dan tutup klinik untuk setiap hari dalam seminggu.
                </p>
            </div>

            <form action="{{ route('admin.schedule.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($schedules as $schedule)
                        <div class="flex items-center gap-4 py-2 border-b border-gray-100">
                            <!-- Day Name -->
                            <div class="w-32 font-medium {{ $schedule->hari == 'Minggu' ? 'text-red-500' : 'text-slate-700' }}">
                                {{ $schedule->hari }}
                            </div>
                            
                            <!-- Time Inputs -->
                            <div class="flex items-center gap-2 {{ $schedule->status ? '' : 'opacity-50' }}" id="time-container-{{ $schedule->id }}">
                                <input type="time" name="schedules[{{ $schedule->id }}][jam_buka]" value="{{ $schedule->jam_buka ? \Carbon\Carbon::parse($schedule->jam_buka)->format('H:i') : '' }}"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                    {{ $schedule->status ? '' : 'disabled' }}>
                                <span class="text-slate-500">-</span>
                                <input type="time" name="schedules[{{ $schedule->id }}][jam_tutup]" value="{{ $schedule->jam_tutup ? \Carbon\Carbon::parse($schedule->jam_tutup)->format('H:i') : '' }}"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                    {{ $schedule->status ? '' : 'disabled' }}>
                            </div>

                            <!-- Toggle Status -->
                            <div class="ml-auto">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="schedules[{{ $schedule->id }}][status]" value="0">
                                    <input type="checkbox" name="schedules[{{ $schedule->id }}][status]" value="1"
                                        {{ $schedule->status ? 'checked' : '' }}
                                        onchange="toggleSchedule({{ $schedule->id }}, this.checked)"
                                        class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-slate-600">Buka</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <script>
                function toggleSchedule(id, isChecked) {
                    const container = document.getElementById('time-container-' + id);
                    const inputs = container.getElementsByTagName('input');
                    
                    if (isChecked) {
                        container.classList.remove('opacity-50');
                        Array.from(inputs).forEach(input => input.disabled = false);
                    } else {
                        container.classList.add('opacity-50');
                        Array.from(inputs).forEach(input => input.disabled = true);
                    }
                }
            </script>
        </div>
    </div>
@endsection