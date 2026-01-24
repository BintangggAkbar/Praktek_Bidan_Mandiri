<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return view('admin.schedule.index', compact('schedules'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'schedules' => 'required|array',
            'schedules.*.status' => 'nullable',
            'schedules.*.jam_buka' => 'nullable', // We handle validation logic manually or rely on fallback
            'schedules.*.jam_tutup' => 'nullable',
        ]);

        foreach ($data['schedules'] as $id => $scheduleData) {
            $schedule = Schedule::findOrFail($id);
            // Checkbox value handling
            $status = (boolean) ($scheduleData['status'] ?? false);

            // Handle time inputs
            // If input is provided, use it. 
            // If not provided (null/empty) because it's disabled or cleared:
            // - If we are Closing (status false), REVERT to existing DB value (or keep it).
            // - If we are Opening (status true), we ideally need a value. If empty, maybe default to 08:00? 
            //   But better to keep existing value if empty.

            $jamBuka = ($scheduleData['jam_buka'] ?? null) ?: $schedule->jam_buka;
            $jamTutup = ($scheduleData['jam_tutup'] ?? null) ?: $schedule->jam_tutup;

            $schedule->update([
                'jam_buka' => $jamBuka,
                'jam_tutup' => $jamTutup,
                'status' => $status,
            ]);
        }

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil diperbarui.');
    }
}
