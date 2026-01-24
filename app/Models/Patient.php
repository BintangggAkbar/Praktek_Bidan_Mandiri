<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'nama_pasien',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'pekerjaan',
        'alergi',
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'pasien_id');
    }

    public function getAgeDetailedAttribute()
    {
        $birthDate = \Carbon\Carbon::parse($this->tanggal_lahir);
        $now = \Carbon\Carbon::now();
        $diff = $birthDate->diff($now);

        return [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];
    }
}
