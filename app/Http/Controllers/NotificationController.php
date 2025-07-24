<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = [];

        $announcements = Announcement::where('is_active', true)
            ->latest()
            ->paginate(10);
        
        $tasks = Task::with(['network', 'assignedUsers', 'creator'])
            ->forUser(Auth::id())
            ->withoutAction()
            ->latest()
            //->take(3)
            ->get();

        $notifications['announcements'] = $announcements;
        $notifications['tasks'] = $tasks;

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
                break;

            default:
                abort(404, 'Tipe notifikasi tidak ditemukan.');
        }

        return view('notifications.detail', compact('data', 'type'));
    }
}
