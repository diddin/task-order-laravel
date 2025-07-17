<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        // Ambil semua chat yang melibatkan user login (sebagai pengirim atau penerima)
        $chats = Chat::with(['fromUser', 'toUser'])
            ->where(function ($query) {
                $query->where('from_user_id', Auth::id())
                    ->orWhere('to_user_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($chat) {
                return Carbon::parse($chat->created_at)->translatedFormat('d F Y');
            });
        
        $users = User::whereIn('role_id', [Role::ROLE_ADMIN, Role::ROLE_MASTER])->get();

        // Debug output (opsional)
        //echo "<pre>"; print_r($users->toArray()); echo "</pre>"; die();

        return view('chat.index', compact('chats', 'users'));
    }

    public function technicianMessages()
    {
        // Ambil semua chat yang melibatkan user login (sebagai pengirim atau penerima)
        $chats = Chat::with(['fromUser', 'toUser'])
            ->where(function ($query) {
                $query->where('from_user_id', Auth::id())
                    ->orWhere('to_user_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($chat) {
                return Carbon::parse($chat->created_at)->translatedFormat('d F Y');
            });
        
        $users = User::whereIn('role_id', [Role::ROLE_ADMIN, Role::ROLE_MASTER])->get();

        // Debug output (opsional)
        //echo "<pre>"; print_r($users->toArray()); echo "</pre>"; die();

        return view('chat.technician-index', compact('chats', 'users'));
    }

    public function send(Request $request)
    { dd($request->all());
        $request->validate([
            'message' => 'required|string|max:1000',
            'to_user_id' => 'required|exists:users,id',
        ]);

        Chat::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'message' => $request->message,
            'created_at' => now(),
        ]);

        return redirect()->back();
    }
}
