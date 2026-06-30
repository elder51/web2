<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );
    }
}
