<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        \App\Models\User::factory()->create([
             'name' => 'CVN',
             'email' => 'cvn.utelvt@gmail.com',
             'password' => 'cvnutelvt2024',
             'role' => 'Administrador',
             'estado' => 1,
         ]);
    }
}
