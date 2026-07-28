<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'anfasanukaloor@gmail.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('App@Kalo9400#'),
                'role' => 'super_admin',
            ]
        );
    }
}
