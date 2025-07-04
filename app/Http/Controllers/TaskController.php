<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;

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
        $tasks = Task::with(['network', 'assignedUser', 'creator'])
                     ->latest()
                     ->paginate(10);

        return view($this->role.'.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $networks = Network::all();

        $users = User::where('role_id', 3)->get();

        return view($this->role.'.tasks.create', compact('networks', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['network', 'assignedUser', 'creator']);

        return view($this->role.'.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $networks = Network::all();
        $users = User::where('role_id', 3)->get();

        return view($this->role.'.tasks.edit', compact('task', 'networks', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
