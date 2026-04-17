<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vetconnect.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'owner@vetconnect.com'],
            [
                'name' => 'Pet Owner',
                'password' => Hash::make('password'),
                'role' => 'pet_owner',
                'status' => true,
            ]
        );
    }
}
