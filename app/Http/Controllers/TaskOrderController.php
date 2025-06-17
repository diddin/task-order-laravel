<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskOrderRequest;
use App\Http\Requests\UpdateTaskOrderRequest;
use App\Models\TaskOrder;
use App\Models\Task;

class TaskOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskOrders = TaskOrder::with('task')->paginate(10);
        return view('taskorders.index', compact('taskOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = Task::all();
        $taskOrder = null;
        return view('taskorders.create', compact('tasks', 'taskOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskOrderRequest $request)
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
        return view('taskorders.show', compact('taskOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        $taskOrder = TaskOrder::findOrFail($id);
        $tasks = Task::all();
        return view('taskorders.edit', compact('taskOrder', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskOrderRequest $request, $id)
    { 
        $taskOrder = TaskOrder::findOrFail($id);
        $taskOrder->update($request->validated());

        return redirect()->route('taskorders.show', $taskOrder)
            ->with('success', 'Task progress updated successfully.');
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
}
