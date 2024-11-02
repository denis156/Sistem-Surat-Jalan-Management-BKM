<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Officer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OfficerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user dengan role 'officer'
        $officerUsers = User::where('role', 'officer')->get();

        foreach ($officerUsers as $user) {
            Officer::create([
                'user_id' => $user->id,
                'type' => $faker->randomElement(['field', 'room', 'warehouse']),
                'is_active' => true,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
