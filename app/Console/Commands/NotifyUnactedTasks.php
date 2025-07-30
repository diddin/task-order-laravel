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
    protected $description = 'Kirim notifikasi untuk tiket yang belum dikerjakan lebih dari 6 jam setelah dibuat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$threshold = Carbon::now()->subHours(6);
        $threshold = now()->subMinutes(1);

        $tasks = Task::with('assignedUsers')
            ->whereNull('action')
            ->where('created_at', '<=', $threshold)
            //->where('notified_no_action', false)
            ->get();

        foreach ($tasks as $task) {
            foreach ($task->assignedUsers as $user) {
                $user->notify(new TaskNoActionReminder($task));
            }

            // tandai task sebagai sudah dikirim notifikasi
            $task->notified_no_action = true;
            $task->save();
        }

        $this->info(count($tasks) . ' tiket diperiksa dan notifikasi dikirim jika perlu.');

        return Command::SUCCESS;
    }
}
