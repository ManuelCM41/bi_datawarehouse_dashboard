<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'dni' => '77298042',
            'name' => 'Manuel',
            'surnames' => 'Chunca Mamani',
            'phone' => fake()->numerify('###') . ' ' . fake()->numerify('###') . ' ' . fake()->numerify('###'),
            'status' => true,
            'email' => 'manuelchunca04@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Super-admin');

        User::create([
            'dni' => '77298041',
            'name' => 'Frank Grimaldy',
            'surnames' => 'Chunca Mamani',
            'phone' => fake()->numerify('###') . ' ' . fake()->numerify('###') . ' ' . fake()->numerify('###'),
            'status' => true,
            'email' => 'frankchunca@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'dni' => '77489560',
            'name' => 'Luis Sandro',
            'surnames' => 'Chunca Mamani',
            'phone' => fake()->numerify('###') . ' ' . fake()->numerify('###') . ' ' . fake()->numerify('###'),
            'status' => true,
            'email' => 'luischunca@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Usuario');

        // Crear usuarios adicionales con el rol 'Usuario' y plan 'Free'
        User::factory(18)->create()->each(function ($user) {
            $user->assignRole('Usuario');
        });
    }
}
