<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BidanScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all(); // Should likely order by ID to keep days in order if seeded correctly
        return view('bidan.schedule.index', compact('schedules'));
    }

    public function edit()
    {
        $schedules = Schedule::all();
        return view('admin.schedule.index', compact('schedules'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'schedules' => 'required|array',
            'schedules.*.jam_buka' => 'nullable', // Use nullable if closed
            'schedules.*.jam_tutup' => 'nullable',
            'schedules.*.status' => 'nullable', // Checkbox
        ]);

        foreach ($data['schedules'] as $id => $scheduleData) {
            $schedule = Schedule::findOrFail($id);
            $status = isset($scheduleData['status']) ? true : false;

            $schedule->update([
                'jam_buka' => $scheduleData['jam_buka'],
                'jam_tutup' => $scheduleData['jam_tutup'],
                'status' => $status,
            ]);
        }

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil diperbarui.');
    }
}
