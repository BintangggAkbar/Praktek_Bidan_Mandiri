<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator Klinik',
            'email' => 'admin@klinik.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Admin Utama No. 1',
        ]);

        // Bidan 1
        User::create([
            'username' => 'bidan1',
            'nama_lengkap' => 'Bidan Siti Aminah',
            'email' => 'bidan1@klinik.test',
            'password' => Hash::make('password'),
            'role' => 'bidan',
            'status' => 'aktif',
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Bidan Melati No. 5',
        ]);

        // Bidan 2
        User::create([
            'username' => 'bidan2',
            'nama_lengkap' => 'Bidan Rina Lestari',
            'email' => 'bidan2@klinik.test',
            'password' => Hash::make('password'),
            'role' => 'bidan',
            'status' => 'aktif',
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Bidan Mawar No. 12',
        ]);
    }
}
