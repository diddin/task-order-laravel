<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\Role;
use App\Events\ChatSent;
use App\Events\ChatRead;
use App\Events\MyEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil chat terakhir per pasangan (from_user_id, to_user_id)
        $latestChats = Chat::selectRaw('
                CASE 
                    WHEN from_user_id = ? THEN to_user_id
                    ELSE from_user_id
                END as other_user_id,
                MAX(created_at) as latest_time
            ', [$userId])
            ->where('from_user_id', $userId)
            ->orWhere('to_user_id', $userId)
            ->groupBy('other_user_id')
            ->orderByDesc('latest_time')
            ->get();

        // Ambil isi chat terakhir dari masing-masing pasangan
        $chats = collect(); 

        foreach ($latestChats as $entry) {
            $chat = Chat::where(function ($query) use ($userId, $entry) {
                    $query->where('from_user_id', $userId)->where('to_user_id', $entry->other_user_id);
                })
                ->orWhere(function ($query) use ($userId, $entry) {
                    $query->where('from_user_id', $entry->other_user_id)->where('to_user_id', $userId);
                })
                ->orderByDesc('created_at')
                ->with(['fromUser', 'toUser'])
                ->first();

            if ($chat) {
                $chats->push($chat);
            }
            $is_read = 1;
            if($chat->to_user_id == $userId) {
                $is_read = $chat->is_read;
            }
            $chat->is_read = $is_read;
        }

        // Ambil user master/admin yang belum pernah diajak chat
        $chatUserIds = $chats->pluck('from_user_id')->merge($chats->pluck('to_user_id'))->unique()->all();
        // $availableUsers = User::whereIn('role_id', [Role::ROLE_MASTER, Role::ROLE_ADMIN])
        //     ->where('id', '!=', $userId)
        //     ->whereNotIn('id', $chatUserIds)
        //     ->orderBy('name')
        //     ->get();

        if (in_array(Auth::user()->role->name, ['admin', 'master'])) {
            $availableUsers = User::where('role_id', Role::ROLE_TECHNICIAN)
                ->where('id', '!=', Auth::id())
                ->whereNotIn('id', $chatUserIds)
                ->orderBy('name')
                ->get();
        } else {
            $availableUsers = User::whereIn('role_id', [Role::ROLE_MASTER, Role::ROLE_ADMIN])
                ->where('id', '!=', Auth::id())
                ->whereNotIn('id', $chatUserIds)
                ->orderBy('name')
                ->get();
        }
        
        //echo '<pre>'; print_r($chats->toArray()); echo '</pre>'; die();

        return view('chat.index', compact('chats', 'availableUsers'));
    }

    public function redirectToThread(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
        ]);

        return redirect()->route('chats.thread', $request->to_user_id);
    }

    public function thread(User $user)
    {
        $authId = Auth::id();

        if ($authId === $user->id) {
            abort(403, 'Tidak bisa chat dengan diri sendiri.');
        }

        // Batasi role yang bisa diajak chat (opsional)
        // if (!in_array($user->role_id, [Role::ROLE_MASTER, Role::ROLE_ADMIN])) {
        //     abort(403, 'Tidak diizinkan mengakses thread ini.');
        // }

        // Tandai semua pesan dari $user ke Auth::user() sebagai sudah dibaca
        Chat::where('from_user_id', $user->id)
            ->where('to_user_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Hapus cache agar hitungan unread chat diperbarui
        // cache()->forget("unread_chats_user_{$authId}");

        // Hitung ulang unread count
        $unreadCount = Chat::unread()->forUser($authId)->count();

        // Broadcast event ke user auth
        // broadcast(new ChatRead($authId, $unreadCount))->toOthers();

        event(new ChatRead($authId, $unreadCount));

        // Ambil semua chat antara dua user ini
        $chats = Chat::with(['fromUser', 'toUser'])
            ->where(function ($query) use ($authId, $user) {
                $query->where('from_user_id', $authId)->where('to_user_id', $user->id);
            })
            ->orWhere(function ($query) use ($authId, $user) {
                $query->where('from_user_id', $user->id)->where('to_user_id', $authId);
            })
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($chat) {
                return Carbon::parse($chat->created_at)->translatedFormat('d F Y');
            });;

        return view('chat.thread', [
            'user' => $user,
            'chats' => $chats,
        ]);
    }
    
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'to_user_id' => 'required|exists:users,id',
        ]);

        $chat = Chat::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'message' => $request->message,
            'created_at' => now(),
        ]);

        // Trigger event
        broadcast(new ChatSent($chat))->toOthers();
        
        Log::info('✅ ChatSent broadcasted from ChatController', ['data' => json_encode($chat)]);

        return response()->json([
            'status' => 'ok',
            'chat' => $chat
        ]);

        // return redirect()->route('chats.thread', $request->to_user_id);
    }
}
