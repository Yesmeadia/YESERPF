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
            ['email' => 'test'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('test'),
                'role' => 'super_admin',
            ]
        );
    }
}
