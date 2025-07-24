<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{

    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $startDate = $this->faker->optional()->dateTimeBetween('-1 month', '+1 month');
        $endDate = $startDate ? $this->faker->dateTimeBetween($startDate, '+2 months') : null;

        return [
            'title' => $this->faker->sentence(6, true),         // Judul pengumuman
            'content' => $this->faker->paragraphs(3, true),     // Isi pengumuman, 3 paragraf jadi satu string
            'is_active' => $this->faker->boolean(80),           // 80% aktif
            'start_date' => $startDate ? $startDate->format('Y-m-d') : null,
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
        ];
    }
}
