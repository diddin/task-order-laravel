<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) {
            User::create([
                'name' => 'Master Admin ' . $i,
                'username' => 'masteradmin' . $i,
                'email' => 'master' . $i . '@example.com',
                'password' => bcrypt('master123'),
                'role_id' => Role::where('name', 'master')->first()->id,
                'phone_number' => '0812' . rand(10000000, 99999999),
                'profile_image' => $this->getRandomDummyImagePath(),
            ]);

            User::create([
                'name' => 'Admin ' . $i,
                'username' => 'admin' . $i,
                'email' => 'admin' . $i . '@example.com',
                'password' => bcrypt('admin123'),
                'role_id' => Role::where('name', 'admin')->first()->id,
                'phone_number' => '0813' . rand(10000000, 99999999),
                'profile_image' => $this->getRandomDummyImagePath(),
            ]);

            User::create([
                'name' => 'Teknisi ' . $i,
                'username' => 'teknisi' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('user123'),
                'role_id' => Role::where('name', 'technician')->first()->id,
                'phone_number' => '0814' . rand(10000000, 99999999),
                'profile_image' => $this->getRandomDummyImagePath(),
            ]);
        }
    }

    private function getRandomDummyImagePath(): ?string
    {
        $random = rand(1, 12);
        $sourcePath = public_path("dummies/profile/profile_dummy{$random}.jpg");

        if (!File::exists($sourcePath)) {
            return null;
        }

        $filename = Str::random(10) . '.jpg';
        $destinationPath = 'profile_images/' . $filename;

        Storage::put($destinationPath, File::get($sourcePath));

        return $destinationPath;
    }
}
