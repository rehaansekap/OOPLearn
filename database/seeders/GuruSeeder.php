<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'guru@ooplearn.com'],
            [
                'name' => 'Guru Pengajar',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'has_seen_tour' => true,
            ]
        );
    }
}
