<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'uuid' => Str::uuid(),
                'personal_token' => Str::random(50),
                'username' => 'admin',
                'url_img' => null,
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // Hashea la contraseña
                'role' => 'admin',
                'verificada' => true,
                'status' => true,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'personal_token' => Str::random(50),
                'username' => 'empleado1',
                'url_img' => null,
                'email' => 'empleado1@example.com',
                'password' => Hash::make('empleado123'),
                'role' => 'empleado',
                'verificada' => false,
                'status' => false,
                'email_verified_at' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
