<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskOrder;
use App\Events\TaskUpdated;
use App\Http\Requests\TaskOrder\TaskOrderStoreRequest;
use App\Http\Requests\TaskOrder\TaskOrderUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskOrderController extends Controller
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
        $taskOrders = TaskOrder::with('task')->paginate(10);
        return view($this->role.'.taskorders.index', compact('taskOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = Task::all();
        $taskOrder = null;
        return view($this->role.'.taskorders.create', compact('tasks', 'taskOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskOrderStoreRequest $request)
    {
        TaskOrder::create($request->validated());

        return redirect()->route('taskorders.index')
            ->with('success', 'Task progress updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    { 
        $taskOrder = TaskOrder::findOrFail($id); //echo '<pre>'; print_r($id); echo "</pre>"; die();
        return view($this->role.'.taskorders.show', compact('taskOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        $taskOrder = TaskOrder::findOrFail($id);
        $tasks = Task::all();
        return view($this->role.'.taskorders.edit', compact('taskOrder', 'tasks'));
    }

    // public function edit($id)
    // { 
    //     $taskOrder = TaskOrder::findOrFail($id);
    //     $tasks = Task::all();
    //     return view('taskorders.edit', compact('taskOrder', 'tasks'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskOrderUpdateRequest $request, $id)
    { 
        $taskOrder = TaskOrder::findOrFail($id);
        $taskOrder->update($request->validated());

        // return redirect()->route('taskorders.show', $taskOrder)
        //     ->with('success', 'Task progress updated successfully.');
        return redirect()->route('technician.taskorders.progress', $taskOrder->task_id)
            ->with('success', 'Task progress berhasil di perbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $taskOrder = TaskOrder::findOrFail($id);
        $taskOrder->delete();

        return redirect()->route('taskorders.index')
            ->with('success', 'Task progress deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function addProgress(Task $task)
    { //dd($task);
        if ($task) {
            $deadline = $task->created_at->copy()->addHours(6);
        
            if (now()->lessThanOrEqualTo($deadline)) {
                $task->remaining = now()->locale('id')->diffForHumans($deadline, [
                    'parts' => 2,
                    'join' => true,
                ]) . ' tersisa';

                // $task->remaining = str_replace('dan', '', $task->remaining);
                // $task->remaining = str_replace('sebelumnya', '', $task->remaining);
                $task->remaining = trim(str_replace(['dan', 'sebelumnya'], '', $task->remaining));
            } else {
                $task->remaining = 'Tidak Tercapai';
            }
        } else {
            return redirect()->route('technicians.dashboard')
                ->with('error', 'Tiket tidak ditemukan atau sudah dihapus.');
        }

        //return view($this->role.'.taskorders.progress-new', compact('task'));

        return view($this->role.'.taskorders.progress', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function storeProgress(TaskOrderStoreRequest $request, Task $task)
    {
        $data = $request->validated(); //dd($task);

        // Jika ada file gambar upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Simpan file di storage/app/public/images dengan nama unik
            $path = $request->file('image')->store('images', 'public');

            // Masukkan path file ke data array (sesuai kolom di DB)
            $data['image'] = $path;
        }

        // Pastikan task_id diisi dengan ID $task (biar tidak asal dari input client)
        $data['task_id'] = $task->id;

        TaskOrder::create($data);

        if (is_null($task->action)) {
            $task->action = 'in progress';
            $task->save();
        }

        // Trigger event
        event(new TaskUpdated($task, $data));

        return redirect()->route('technician.taskorders.progress', $task->id)
            ->with('success', 'Update Progres Berhasil.');
    }
}
