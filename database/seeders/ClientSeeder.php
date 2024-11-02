<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil semua pengguna dengan role 'client'
        $clientUsers = User::where('role', 'client')->get();

        foreach ($clientUsers as $user) {
            Client::create([
                'user_id' => $user->id,
                'company_name' => $faker->company,
                'company_address' => $faker->address,
                'is_active' => true,
            ]);
        }
    }
}
