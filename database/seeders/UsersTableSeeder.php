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
            'username' => 'admin_IkaHer',
            'nama_lengkap' => 'Admin Ika',
            'email' => 'bintang.ggakbar27@gmail.com',
            'password' => Hash::make('Admin123IkaHer'),
            'role' => 'admin',
            'status' => 'aktif',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Admin Utama No. 1',
        ]);
    }
}
