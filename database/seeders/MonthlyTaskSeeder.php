<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedMonthlyTasks(2025, 6, 300); // Juni
        $this->seedMonthlyTasks(2025, 7, 400); // Juli
        $this->seedMonthlyTasks(2025, 8, 500); // Agustus
    }

    protected function seedMonthlyTasks(int $year, int $month, int $customerMaxId)
    {
        $customers = Customer::where('id', '<=', $customerMaxId)->get();
        $customerCount = $customers->count();

        if ($customerCount === 0) {
            $this->command->warn("Tidak ada customer untuk bulan {$month}");
            return;
        }

        $taskPercentage = rand(5, 10); // ambil random antara 5 - 10 %
        $taskCount = (int) ceil($customerCount * $taskPercentage / 100);

        $this->command->info("Membuat {$taskCount} task untuk bulan {$month} ({$year})...");

        Task::factory()
        ->count($taskCount)
        ->state(function () use ($year, $month, $customers) {
            $createdAt = Carbon::create($year, $month, rand(1, 28), rand(8, 16), rand(0, 59));
            $customer = $customers->random();

            if (in_array($month, [6, 7])) {
                $completedAt = (clone $createdAt)->addHours(rand(5, 7));
                return [
                    'created_at'   => $createdAt,
                    'updated_at'   => $completedAt,
                    'completed_at' => $completedAt,
                    'action'       => 'completed',
                    'customer_id'  => $customer->id,
                    'category'     => $customer->category,
                ];
            }

            return [
                'created_at'   => $createdAt,
                'updated_at'   => $createdAt,
                'completed_at' => null,
                'action'       => fake()->randomElement(['in progress', null]),
                'customer_id'  => $customer->id,
                'category'     => $customer->category,
            ];
        })
        ->create();

        $this->command->info("Berhasil membuat {$taskCount} task untuk bulan {$month} ({$year})");
        $this->command->info("Total task saat ini: " . Task::count());
    }
}
