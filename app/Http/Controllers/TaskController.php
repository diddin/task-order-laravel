<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// tanpa listener
use App\Mail\TicketCreatedMail;
use Illuminate\Support\Facades\Mail;

// dengan listener
use App\Events\TicketCreated;

class TaskController extends Controller
{
    private $role;

    public function __construct(Auth $auth)
    {
        $this->role = $auth::user()->role->name;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( $this->role == 'master' || $this->role == 'admin') {
            $tasks = Task::with(['network', 'assignedUsers', 'creator'])
                ->latest()
                ->paginate(10);
        } elseif($this->role == 'technician') {
            // Tiket Baru untuk Anda (belum direspons)
            // $newTasks = Task::with(['network', 'assignedUser', 'creator'])
            //     ->forUser($userId)
            //     ->withoutAction()
            //     ->latest()
            //     ->take(10)
            //     ->get();

            // $yourActivities = Task::with(['network', 'assignedUser', 'creator'])
            //     ->forUser($userId)
            //     ->withAction()
            //     ->latest()
            //     ->take(10)
            //     ->get();

            // $tasks = [
            //     'newTasks' => $newTasks,
            //     'yourActivities' => $yourActivities,
            // ];

            // $tasks = Task::with(['network', 'assignedUser', 'creator'])
            //     ->where('assigned_user_id', Auth::id())
            //     ->latest()
            //     ->paginate(10);

            $tasks = Task::with(['network', 'assignedUsers', 'creator'])
                ->forUser(Auth::id())
                ->withAction()
                ->latest()
                //->take(3)
                ->get();
            
        } else {
            abort(403, 'Unauthorized action.');
        } //echo "<pre>"; print_r($tasks->toArray()); echo "</pre>"; die();

        return view($this->role.'.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $networks = Network::all();
        $users = User::where('role_id', 3)->get();

        // Kosongkan default nilai untuk form
        $pic = null;
        $onsiteTeam = [];

        return view($this->role . '.tasks.create', compact('task', 'networks', 'users', 'pic', 'onsiteTeam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            // Buat task-nya
            $task = Task::create([
                'detail' => $request->detail,
                'network_id' => $request->network_id,
                'created_by' => Auth::id(),
                'action' => $request->action,
            ]);
    
            // Siapkan data untuk pivot (user_id => ['role_in_task' => ...])
            $assignData = [];
    
            // Tambahkan PIC
            if ($request->pic_id) {
                $assignData[$request->pic_id] = ['role_in_task' => 'pic'];
            }
    
            // Tambahkan tim onsite
            if ($request->onsite_ids) {
                foreach ($request->onsite_ids as $userId) {
                    $assignData[$userId] = ['role_in_task' => 'onsite'];
                }
            }
    
            // Attach ke pivot table
            $task->assignedUsers()->attach($assignData);
    
            // Trigger event
            event(new TicketCreated($task));
    
            DB::commit();
    
            return to_route($this->role.'.tasks.index')->with('success', 'Tiket berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan tiket: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['network', 'assignedUsers', 'creator']);

        //echo "<pre>"; print_r($task->toArray()); echo "</pre>"; die();

        return view($this->role.'.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $networks = Network::all();
        $users = User::where('role_id', 3)->get(); // teknisi

        // Ambil semua assigned users (PIC & onsite) dari relasi pivot
        $assignedUsers = $task->assignedUsers;

        $pic = $assignedUsers->firstWhere('pivot.role_in_task', 'pic');
        $onsiteTeam = $assignedUsers->where('pivot.role_in_task', 'onsite')->pluck('id')->toArray();

        return view($this->role.'.tasks.edit', compact('task', 'networks', 'users', 'pic', 'onsiteTeam'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        DB::beginTransaction();

        try {
            // Update data utama task
            $task->update([
                'detail' => $request->detail,
                'network_id' => $request->network_id,
                'action' => $request->action,
            ]);

            // Reset semua assignment lama
            $task->assignedUsers()->detach();

            // Buat ulang assignment berdasarkan form
            $assignData = [];

            // PIC
            if ($request->pic_id) {
                $assignData[$request->pic_id] = ['role_in_task' => 'pic'];
            }

            // Tim onsite (hapus jika ada yang sama dengan PIC)
            $onsiteIds = collect($request->onsite_ids)->filter(function ($id) use ($request) {
                return $id != $request->pic_id;
            });

            foreach ($onsiteIds as $userId) {
                $assignData[$userId] = ['role_in_task' => 'onsite'];
            }

            // Simpan ke pivot
            $task->assignedUsers()->attach($assignData);

            // Trigger event
            event(new TicketCreated($task));

            DB::commit();

            return to_route($this->role.'.tasks.index')
                ->with('success', 'Tiket '.$task->detail. ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update Tiket: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route($this->role.'.tasks.index')->with('success', 'Tiket berhasil dihapus.');
    }

    public function completeProgress(Request $request, Task $task)
    {
        // Ubah status 'action' menjadi 'completed'
        $task->update([
            'action' => 'completed'
        ]);

        return redirect()->route($this->role.'.dashboard')
            ->with('success', 'Tiket berhasil diselesaikan.');
    }
}
