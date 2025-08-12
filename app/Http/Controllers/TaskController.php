<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// tanpa listener
use App\Mail\TicketCreatedMail;
use Illuminate\Support\Facades\Mail;

// dengan listener
use App\Events\TaskCreated;
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
    public function index(Request $request)
    {
        $actionFilter = $request->input('action');
        $categoryFilter = $request->input('category');

        if( $this->role == 'master' || $this->role == 'admin') {
            $query = Task::with(['customer', 'assignedUsers', 'creator'])->latest();
        } elseif($this->role == 'technician') {
            $query = Task::with(['customer', 'assignedUsers', 'creator'])
                ->forUser(Auth::id())
                ->withAction()
                ->latest();
            
        } else {
            abort(403, 'Unauthorized action.');
        } //echo "<pre>"; print_r($tasks->toArray()); echo "</pre>"; die();

        if (in_array($actionFilter, ['in progress', 'completed', 'null'])) {
            if ($actionFilter === 'null') {
                $query->whereNull('action');
            } else {
                $query->where('action', $actionFilter);
            }
        }

        if (in_array($categoryFilter, ['akses', 'backbone'])) {
            $query->where('category', $categoryFilter);
        }

        $tasks = $this->role === 'technician' ? $query->get() : $query->paginate(10)->appends(['action' => $actionFilter, 'category' => $categoryFilter]);

        return view($this->role.'.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $customers = Customer::all();
        $users = User::where('role_id', 3)->get();

        // Kosongkan default nilai untuk form
        $pic = null;
        $onsiteTeam = [];

        return view($this->role . '.tasks.create', compact('task', 'customers', 'users', 'pic', 'onsiteTeam'));
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
                'task_number' => $request->task_number,
                'detail' => $request->detail,
                'category' => $request->category,
                'customer_id' => $request->customer_id,
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
            // event(new TaskCreated($task));
    
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
        $task->load(['customer', 'assignedUsers', 'creator']);

        if ($task->orders->isEmpty()) {
            // Tidak ada order, mungkin set durasi 0 atau nilai default
            $hours = $minutes = $seconds = 0;
        } else {
            $startTime = Carbon::parse($task->orders->first()->created_at);
            $endTime = Carbon::parse($task->orders->last()->created_at);

            $totalHoldDuration = 0;
            $currentHoldStart = null;

            foreach ($task->orders as $order) {
                if ($order->type === 'hold') {
                    $currentHoldStart = Carbon::parse($order->hold_started_at ?? $order->created_at);
                }

                if ($order->type === 'resume' && $currentHoldStart) {
                    $resumeTime = Carbon::parse($order->resumed_at ?? $order->created_at);
                    $totalHoldDuration += $resumeTime->diffInSeconds($currentHoldStart);
                    $currentHoldStart = null;
                }
            }

            $effectiveDuration = $endTime->diffInSeconds($startTime) - $totalHoldDuration;
            $hours = floor($effectiveDuration / 3600);
            $minutes = floor(($effectiveDuration % 3600) / 60);
            $seconds = $effectiveDuration % 60;
        }

        // echo "Durasi Efektif Pengerjaan: {$hours} jam, {$minutes} menit, {$seconds} detik";

        // echo "<pre>"; print_r($task->toArray()); echo "</pre>"; die();

        return view($this->role.'.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $customers = Customer::all();
        $users = User::where('role_id', 3)->get(); // teknisi

        // Ambil semua assigned users (PIC & onsite) dari relasi pivot
        $assignedUsers = $task->assignedUsers;

        $pic = $assignedUsers->firstWhere('pivot.role_in_task', 'pic');
        $onsiteTeam = $assignedUsers->where('pivot.role_in_task', 'onsite')->pluck('id')->toArray();

        return view($this->role.'.tasks.edit', compact('task', 'customers', 'users', 'pic', 'onsiteTeam'));
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
                'task_number' => $request->task_number,
                'detail' => $request->detail,
                'category' => $request->category,
                'customer_id' => $request->customer_id,
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
            event(new TaskCreated($task));

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
