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
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            NetworkSeeder::class,
            TaskSeeder::class,
            TaskOrderSeeder::class,
            AssetSeeder::class,
            AssetPortSeeder::class,
            AssetImageSeeder::class,
            ChatSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
