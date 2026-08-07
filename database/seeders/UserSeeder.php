<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'phone' => '03001234567',
            'email' => 'admin@.com',
            'password' => Hash::make('123456'),
            'status' => true,
        ]);

        User::create([
            'name' => 'Staff',
            'phone' => '03111234567',
            'email' => 'staff@.com',
            'password' => Hash::make('123456'),
            'status' => true,
        ]);
    }
}
