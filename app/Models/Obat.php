<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';

    protected $fillable = [
        'nama_obat',
        'dosis',
        'kategori_obat',
        'bentuk_sediaan',
        'stok',
        'satuan',
    ];

    public function medicalRecords()
    {
        return $this->belongsToMany(MedicalRecord::class, 'resep_obats', 'obat_id', 'rekam_medis_id')
            ->withPivot('jumlah', 'dosis')
            ->withTimestamps();
    }
}
