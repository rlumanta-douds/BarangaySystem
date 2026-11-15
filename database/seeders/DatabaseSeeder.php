<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin Account with the required role
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@barangay.gov.ph',
            'password' => Hash::make('password123'),
            'role' => 'admin', // If this doesn't work, try 'administrator' or '1'
        ]);
    }
}