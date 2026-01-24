<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'dosis' => '500mg',
                'kategori_obat' => 'analgesik',
                'bentuk_sediaan' => 'tablet',
                'stok' => 100,
                'satuan' => 'strip',
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'dosis' => '500mg',
                'kategori_obat' => 'antibiotik',
                'bentuk_sediaan' => 'kapsul',
                'stok' => 50,
                'satuan' => 'strip',
            ],
            [
                'nama_obat' => 'Vitamin C',
                'dosis' => '500mg',
                'kategori_obat' => 'vitamin',
                'bentuk_sediaan' => 'tablet',
                'stok' => 200,
                'satuan' => 'botol',
            ],
            [
                'nama_obat' => 'Antasida',
                'dosis' => '200mg',
                'kategori_obat' => 'obat luar',
                'bentuk_sediaan' => 'sirup',
                'stok' => 30,
                'satuan' => 'botol',
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'dosis' => '400mg',
                'kategori_obat' => 'analgesik',
                'bentuk_sediaan' => 'tablet',
                'stok' => 75,
                'satuan' => 'strip',
            ],
            [
                'nama_obat' => 'Betadine',
                'dosis' => '10%',
                'kategori_obat' => 'obat luar',
                'bentuk_sediaan' => 'salep',
                'stok' => 40,
                'satuan' => 'tube',
            ]
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
