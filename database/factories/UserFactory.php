<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'profile_image' => null,
            'phone_number' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withImage()
    {
        $dummies = [];

        // Buat array nama file profile_dummy1.jpg sampai profile_dummy12.jpg
        for ($i = 1; $i <= 12; $i++) {
            $dummies[] = public_path("dummies/profile/profile_dummy{$i}.jpg");
        }

        // Pilih satu file random dari $dummies
        $randomDummy = $dummies[array_rand($dummies)];

        // Pastikan file ada
        if (!file_exists($randomDummy)) {
            return $this; // Kalau file gak ada, skip
        }

        // Generate nama file random untuk simpan di storage/app/public/images
        $filename = Str::random(10) . '.jpg';
        $storagePath = 'profile_images/' . $filename;

        // Simpan file dummy ke storage
        Storage::put($storagePath, File::get($randomDummy));

        return $this->state(fn () => [
            'profile_image' => $storagePath,
        ]);
    }
}
