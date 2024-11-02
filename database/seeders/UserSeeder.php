<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Buat pengguna khusus admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'address' => 'Jl. Merdeka No.1, Jakarta',
            'phone_number' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Buat satu pengguna khusus client
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'address' => 'Jl. Kebon Jeruk No.2, Bandung',
            'phone_number' => '081298765432',
            'email_verified_at' => now(),
        ]);

        // Buat beberapa pengguna acak dengan role client
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('password123'),
                'role' => 'client',
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'avatar_url' => 'https://i.pravatar.cc/150?img=' . $faker->numberBetween(1, 70), // Avatar random
                'email_verified_at' => now(),
            ]);
        }

        // Buat beberapa pengguna acak dengan role officer
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('password123'),
                'role' => 'officer',
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'avatar_url' => 'https://i.pravatar.cc/150?img=' . $faker->numberBetween(1, 70), // Avatar random
                'email_verified_at' => now(),
            ]);
        }
    }
}
