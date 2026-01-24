<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class LayanansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanans = [
            [
                'nama_layanan' => 'Pemeriksaan Kehamilan',
                'deskripsi' => 'Pemeriksaan rutin untuk ibu hamil.',
            ],
            [
                'nama_layanan' => 'Imunisasi',
                'deskripsi' => 'Pemberian vaksin untuk bayi dan balita.',
            ],
            [
                'nama_layanan' => 'Konsultasi KB',
                'deskripsi' => 'Konsultasi mengenai metode Keluarga Berencana.',
            ],
            [
                'nama_layanan' => 'Pemeriksaan Umum',
                'deskripsi' => 'Pemeriksaan kesehatan umum.',
            ],
        ];

        foreach ($layanans as $layanan) {
            Service::create($layanan);
        }
    }
}
