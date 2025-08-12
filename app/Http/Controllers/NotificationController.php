<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [];

        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->paginate(10);

        $notifications['announcements'] = $announcements;

        return view('notifications.index', compact('notifications'));
    }

    public function detail(Request $request, int $id)
    {
        $type = $request->type;
        $data = null;

        switch ($type) {
            case 'announcement':
                $data = Announcement::findOrFail($id);
                break;

            case 'task':
                $data = Task::findOrFail($id);
                // mark as read notification
                DB::table('task_user_assignment')
                    ->where('user_id', Auth::id())
                    ->where('task_id', $data->id)
                    ->update(['is_read' => true]);
                // if cached remove also
                cache()->forget("unread_tasks_user_" . Auth::id());
                break;

            default:
                abort(404, 'Tipe notifikasi tidak ditemukan.');
        }

        return view('notifications.detail', compact('data', 'type'));
    }

    public function markAllTasksAsRead()
    {
        $userId = Auth::id();

        DB::table('task_user_assignment')
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Clear cache jika pakai caching di NotificationService
        cache()->forget("unread_tasks_user_{$userId}");

        return redirect()->back()->with('success', 'Semua notifikasi task ditandai sudah dibaca.');
    }
}
