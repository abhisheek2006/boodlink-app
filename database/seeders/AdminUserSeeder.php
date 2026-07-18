<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@bloodbank.com'],
            [
                'role' => 'Admin',
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'phone' => '9999999999',
                'gender' => 'Other',
                'dob' => now()->subYears(30)->toDateString(),
                'status' => 'Active',
                'email_verified_at' => now(),
            ]
        );
    }
}
