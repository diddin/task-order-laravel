<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function getUnreadTaskCount(): int
    {
        $user = Auth::user();
        if (!$user) {
            return 0;
        }

        return cache()->remember("unread_tasks_user_{$user->id}", now()->addMinutes(5), function () use ($user) {
            return DB::table('task_user_assignment')
                ->where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
        });
    }
}
