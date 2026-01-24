<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'bidan_id',
        'layanan_id',
        'keluhan_utama',
        'tekanan_darah',
        'nadi',
        'frekuensi_pernapasan',
        'berat_badan',
        'suhu_tubuh',
        'pemeriksaan_fisik',
        'diagnosis',
        'tindakan',
        'biaya',
    ];

    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function bidan()
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Service::class, 'layanan_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Obat::class, 'resep_obats', 'rekam_medis_id', 'obat_id')
            ->withPivot('jumlah', 'dosis')
            ->withTimestamps();
    }
}
