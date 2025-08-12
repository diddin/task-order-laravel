<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskNoActionReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class NotifyUnactedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:notify-unacted-tasks';
    protected $signature = 'tasks:notify-unacted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi untuk tiket yang belum dikerjakan sampai 6 jam setelah dibuat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$threshold = now()->subHours(6); // 6 jam sebelumnya
        $threshold = now()->subMinutes(1); // Untuk testing, bisa diganti dengan 1 menit agar cepat terlihat hasilnya

        $tasks = Task::with('assignedUsers')
            ->whereNull('action')
            ->where('created_at', '<=', $threshold) // hanya yang sudah LEWAT 6 jam
            //->where('created_at', '>=', $threshold) // hanya yang masih dalam atau belum LEWAT 6 jam
            ->where('notified_no_action', false)
            ->get();

        foreach ($tasks as $task) {
            if ($task->created_at->lte($threshold)) {
                // Sudah lewat 6 jam, tandai agar tidak dikirim notifikasi lagi
                $task->notified_no_action = true;
                $task->save();
                continue; // Skip pengiriman notifikasi
            }

            // Masih dalam 6 jam → kirim notifikasi
            foreach ($task->assignedUsers as $user) {
                $user->notify(new TaskNoActionReminder($task));
            }
        }

        $this->info(count($tasks) . ' tiket diperiksa dan notifikasi dikirim jika perlu.');

        return Command::SUCCESS;
    }
}
