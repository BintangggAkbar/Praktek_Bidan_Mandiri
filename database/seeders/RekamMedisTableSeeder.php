<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;

class RekamMedisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasienIds = Patient::pluck('id')->toArray();
        $bidanIds = User::where('role', 'bidan')->pluck('id')->toArray();
        $layananIds = \App\Models\Service::pluck('id')->toArray();
        $obatIds = \App\Models\Obat::pluck('id')->toArray();

        // Ensure we have data
        if (empty($pasienIds) || empty($bidanIds) || empty($layananIds)) {
            return;
        }

        $records = [
            [
                'keluhan_utama' => 'Demam dan sakit kepala',
                'tekanan_darah' => '120/80',
                'nadi' => 80,
                'frekuensi_pernapasan' => 20,
                'berat_badan' => 60,
                'suhu_tubuh' => 38.5,
                'pemeriksaan_fisik' => 'Kondisi umum tampak lemas.',
                'diagnosis' => 'Febris',
                'tindakan' => 'Kompres hangat, istirahat cukup.',
                'biaya' => 50000,
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'keluhan_utama' => 'Batuk berdahak',
                'tekanan_darah' => '110/70',
                'nadi' => 85,
                'frekuensi_pernapasan' => 22,
                'berat_badan' => 55,
                'suhu_tubuh' => 37.0,
                'pemeriksaan_fisik' => 'Suara napas vesikuler, tidak ada wheezing.',
                'diagnosis' => 'ISPA',
                'tindakan' => 'Minum air hangat, hindari gorengan.',
                'biaya' => 75000,
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'keluhan_utama' => 'Pusing dan mual',
                'tekanan_darah' => '100/60',
                'nadi' => 78,
                'frekuensi_pernapasan' => 18,
                'berat_badan' => 58,
                'suhu_tubuh' => 36.5,
                'pemeriksaan_fisik' => 'Konjungtiva anemis (-).',
                'diagnosis' => 'Dyspepsia',
                'tindakan' => 'Makan sedikit tapi sering.',
                'biaya' => 60000,
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'keluhan_utama' => 'Luka lecet di kaki',
                'tekanan_darah' => '120/80',
                'nadi' => 82,
                'frekuensi_pernapasan' => 20,
                'berat_badan' => 65,
                'suhu_tubuh' => 36.8,
                'pemeriksaan_fisik' => 'Luka terbuka dangkal di kaki kanan.',
                'diagnosis' => 'Vulnus Excoriatum',
                'tindakan' => 'Pembersihan luka, pemberian antiseptik.',
                'biaya' => 80000,
                'created_at' => Carbon::now()->subWeeks(1),
            ],
            [
                'keluhan_utama' => 'Nyeri otot',
                'tekanan_darah' => '130/80',
                'nadi' => 84,
                'frekuensi_pernapasan' => 20,
                'berat_badan' => 70,
                'suhu_tubuh' => 36.7,
                'pemeriksaan_fisik' => 'Nyeri tekan pada otot punggung.',
                'diagnosis' => 'Myalgia',
                'tindakan' => 'Istirahat, kompres hangat.',
                'biaya' => 55000,
                'created_at' => Carbon::now()->subWeeks(2),
            ],
            [
                'keluhan_utama' => 'Sakit gigi',
                'tekanan_darah' => '120/80',
                'nadi' => 80,
                'frekuensi_pernapasan' => 20,
                'berat_badan' => 62,
                'suhu_tubuh' => 37.0,
                'pemeriksaan_fisik' => 'Gigi berlubang pada geraham bawah kanan.',
                'diagnosis' => 'Pulpitis',
                'tindakan' => 'Konsul ke dokter gigi.',
                'biaya' => 50000,
                'created_at' => Carbon::now()->subMonths(1),
            ],
            [
                'keluhan_utama' => 'Gatal-gatal',
                'tekanan_darah' => '110/70',
                'nadi' => 76,
                'frekuensi_pernapasan' => 18,
                'berat_badan' => 50,
                'suhu_tubuh' => 36.5,
                'pemeriksaan_fisik' => 'Ruam kemerahan di tangan.',
                'diagnosis' => 'Dermatitis Alergi',
                'tindakan' => 'Hindari pemicu alergi.',
                'biaya' => 65000,
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'keluhan_utama' => 'Kontrol kehamilan',
                'tekanan_darah' => '110/70',
                'nadi' => 80,
                'frekuensi_pernapasan' => 20,
                'berat_badan' => 68,
                'suhu_tubuh' => 36.6,
                'pemeriksaan_fisik' => 'Tahu hamil 24 minggu, DJJ positif.',
                'diagnosis' => 'G1P0A0 Hamil 24 Minggu',
                'tindakan' => 'Pemberian vitamin.',
                'biaya' => 100000,
                'created_at' => Carbon::now()->subDays(1),
            ]
        ];

        foreach ($records as $index => $record) {
            $createdRecord = MedicalRecord::create(array_merge($record, [
                'pasien_id' => $pasienIds[$index % count($pasienIds)],
                'bidan_id' => $bidanIds[$index % count($bidanIds)],
                'layanan_id' => $layananIds[$index % count($layananIds)],
            ]));

            // Attach random medicines if available
            if (!empty($obatIds)) {
                $randomObatIds = collect($obatIds)->random(rand(1, 2));
                foreach ($randomObatIds as $obatId) {
                    $createdRecord->medicines()->attach($obatId, [
                        'jumlah' => rand(1, 10),
                        'dosis' => rand(1, 3) . 'x1'
                    ]);
                }
            }
        }
    }
}
