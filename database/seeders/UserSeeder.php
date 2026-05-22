<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Utilisateur Test',
            'email'    => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Autre Utilisateur',
            'email'    => 'autre@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}