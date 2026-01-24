<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class JadwalKlinikTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($days as $day) {
            if ($day == 'Minggu') {
                Schedule::create([
                    'hari' => $day,
                    'jam_buka' => '00:00:00',
                    'jam_tutup' => '00:00:00',
                    'status' => false,
                ]);
            } elseif ($day == 'Sabtu') {
                Schedule::create([
                    'hari' => $day,
                    'jam_buka' => '08:00:00',
                    'jam_tutup' => '12:00:00',
                    'status' => true,
                ]);
            } else {
                Schedule::create([
                    'hari' => $day,
                    'jam_buka' => '08:00:00',
                    'jam_tutup' => '16:00:00',
                    'status' => true,
                ]);
            }
        }
    }
}
