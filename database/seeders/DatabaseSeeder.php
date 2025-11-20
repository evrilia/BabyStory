<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StatisticSeeder::class,
            YearlyStatisticSeeder::class,
        ]);

        // 2. Buat Akun Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('123456'), // Kita SET ke 123456 biar gampang
        ]);
    }
}