<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Chat::factory()->count(20)->create();
        // Anggap ini user A (admin/master)
        $adminUsers = User::whereIn('id', [1, 2, 4, 5, 7, 8, 10, 11])->get();

        // Ini user B (dengan role_id = 3)
        $clientUsers = User::where('role_id', 3)->get();

        // Loop semua admin
        foreach ($adminUsers as $admin) {
            // Ambil random 1-3 user B untuk tiap admin
            $targets = $clientUsers->random(rand(1, 3));

            foreach ($targets as $client) {
                // Buat percakapan bolak-balik
                for ($i = 0; $i < rand(2, 5); $i++) {
                    Chat::create([
                        'from_user_id' => $i % 2 === 0 ? $admin->id : $client->id,
                        'to_user_id'   => $i % 2 === 0 ? $client->id : $admin->id,
                        'message'      => fake()->sentence,
                        'created_at'   => Carbon::now()->subDays(rand(0, 5))->setTime(rand(8, 17), rand(0, 59)),
                    ]);
                }
            }
        }
    }
}
