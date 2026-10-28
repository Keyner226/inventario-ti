<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // El modelo User ya encripta 'password' automáticamente (cast 'hashed')
        User::updateOrCreate(
            ['email' => 'admin@ejemplo.com'],
            [
                'name'     => 'Administrador',
                'password' => 'admin123',
            ]
        );
    }
}