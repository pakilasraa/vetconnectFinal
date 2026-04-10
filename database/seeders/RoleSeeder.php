<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@vetconnect.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'status' => true,
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'staff@vetconnect.com'],
            [
                'name' => 'Staff User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'staff',
                'status' => true,
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'vet@vetconnect.com'],
            [
                'name' => 'Vet User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'vet',
                'status' => true,
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'owner@vetconnect.com'],
            [
                'name' => 'Pet Owner',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'owner',
                'status' => true,
            ]
        );
    }
}
