<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'layanans';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'status',
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'layanan_id');
    }
}
