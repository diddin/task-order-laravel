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
        // $threshold = now()->subMinutes(1); // Untuk testing, bisa diganti dengan 1 menit agar cepat terlihat hasilnya
        
        // ini hanya mengambil tiket yang belum ada tindakan (action)
        // $tasks = Task::with('assignedUsers')
        //     ->whereNull('action') // hanya yang belum ada tindakan
        //     ->where('created_at', '<=', $threshold) // hanya yang sudah LEWAT threshold
        //     //->where('created_at', '>=', $threshold) // // hanya yang masih dalam atau belum LEWAT 6 jam (threshold)
        //     ->where('notified_no_action', false) // hanya yang belum pernah diberi notifikasi
        //     ->get();

        $tasks = Task::with('assignedUsers')
            ->whereNull('action')
            ->where('notified_no_action', false)
            ->get();

        $threshold = now()->subHours(6);

        foreach ($tasks as $task) {

            // Sudah lewat 6 jam, tandai agar tidak dikirim notifikasi lagi
            if ($task->created_at->lte($threshold)) {
                // Tandai bahwa task ini tidak perlu dikirim notifikasi lagi
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
