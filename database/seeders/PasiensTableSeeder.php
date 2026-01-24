<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PasiensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasiens = [
            [
                'nama_pasien' => 'Susi Susanti',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-05-15',
                'alamat' => 'Jl. Merpati No. 10, Jakarta',
                'no_hp' => '081333444555',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'alergi' => 'Antibiotik (Penicillin)',
            ],
            [
                'nama_pasien' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-08-20',
                'alamat' => 'Jl. Kutilang No. 5, Bandung',
                'no_hp' => '081222333444',
                'pekerjaan' => 'Wiraswasta',
                'alergi' => null,
            ],
            [
                'nama_pasien' => 'Dewi Lestari',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1995-02-10',
                'alamat' => 'Jl. Kenari No. 8, Surabaya',
                'no_hp' => '081555666777',
                'pekerjaan' => 'Mahasiswa',
                'alergi' => 'Debu',
            ],
            [
                'nama_pasien' => 'Ahmad Rizky',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2000-11-25',
                'alamat' => 'Jl. Melati No. 3, Yogyakarta',
                'no_hp' => '081999888777',
                'pekerjaan' => 'Pelajar',
                'alergi' => null,
            ],
            [
                'nama_pasien' => 'Ratna Sari',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1988-04-05',
                'alamat' => 'Jl. Mawar No. 12, Semarang',
                'no_hp' => '081777666555',
                'pekerjaan' => 'Karyawan Swasta',
                'alergi' => 'Kacang',
            ],
        ];

        foreach ($pasiens as $pasien) {
            Patient::create($pasien);
        }
    }
}
