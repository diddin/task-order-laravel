<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) {
            User::create([
                'name' => 'Master Admin '.$i,
                'email' => 'master'.$i.'@example.com',
                'password' => bcrypt('master123'),
                'role_id' => Role::where('name', 'master')->first()->id,
            ]);
    
            User::create([
                'name' => 'Admin '.$i,
                'email' => 'admin'.$i.'@example.com',
                'password' => bcrypt('admin123'),
                'role_id' => Role::where('name', 'admin')->first()->id,
            ]);
    
            User::create([
                'name' => 'Teknisi '.$i,
                'email' => 'user'.$i.'@example.com',
                'password' => bcrypt('user123'),
                'role_id' => Role::where('name', 'technician')->first()->id,
            ]);

        }
        // User::create([
        //     'name' => 'Master Admin',
        //     'email' => 'master@example.com',
        //     'password' => bcrypt('master123'),
        //     'role_id' => Role::where('name', 'master')->first()->id,
        // ]);

        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('admin123'),
        //     'role_id' => Role::where('name', 'admin')->first()->id,
        // ]);

        // User::create([
        //     'name' => 'User',
        //     'email' => 'user@example.com',
        //     'password' => bcrypt('user123'),
        //     'role_id' => Role::where('name', 'user')->first()->id,
        // ]);
    }
}
