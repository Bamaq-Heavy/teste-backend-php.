<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'cpf' => '091.789.654-85',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('teste123'),
        ]);

        User::create([
            'name' => 'Diego',
            'cpf' => '091.789.654-00',
            'email' => 'diego@gmail.com',
            'password' => Hash::make('teste123'),
        ]);
    }
}
