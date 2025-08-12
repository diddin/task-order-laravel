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
            // mark as read notification
            DB::table('task_user_assignment')
                ->where('user_id', Auth::id())
                ->where('task_id', $task->id)
                ->update(['is_read' => true]);
            // if cached remove also
            cache()->forget("unread_tasks_user_" . Auth::id());

            $deadline = $task->created_at->copy()->addHours(6);
        
            if (now()->lessThanOrEqualTo($deadline)) {
                $task->remaining = now()->locale('id')->diffForHumans($deadline, [
                    'parts' => 2,
                    'join' => true,
                ]) . ' tersisa';
                
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
        $data = $request->validated();

        // Default timestamps
        if ($data['type'] === 'hold') {
            $data['hold_started_at'] = now();
        } elseif ($data['type'] === 'resume') {
            $data['resumed_at'] = now();
        }

        // Jika ada file gambar upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Simpan file di storage/app/public/images dengan nama unik
            $path = $request->file('image')->store('images', 'public');

            // Masukkan path file ke data array (sesuai kolom di DB)
            $data['image'] = $path;
        }

        // Pastikan task_id diisi dengan ID $task (biar tidak asal dari input client)
        $data['task_id'] = $task->id;

        // Simpan ke database
        $task->orders()->create([
            'type'            => $data['type'],
            'status'          => $data['status'],
            'image'           => $request->file('image')?->store('task_orders', 'public'),
            'latitude'        => $data['latitude'],
            'longitude'       => $data['longitude'],
            'hold_started_at' => $data['hold_started_at'] ?? null,
            'resumed_at'      => $data['resumed_at'] ?? null,
        ]);

        //TaskOrder::create($data);

        if (is_null($task->action)) {
            $task->action = 'in progress';
            $task->save();
        }

        // Trigger event
        event(new TaskUpdated($task, $data));

        return redirect()->route('technician.taskorders.progress', $task->id)
            ->with('success', 'Update Progres Berhasil.');
    }

    public function progressDuration(Task $task){
        $taskOrders = TaskOrder::where('task_id', 12)->orderBy('created_at')->get();

        $startTime = $taskOrders->first()->created_at;
        $endTime = $taskOrders->last()->created_at;

        $totalHoldDuration = 0;
        $currentHoldStart = null;

        foreach ($taskOrders as $order) {
            if ($order->type === 'hold') {
                $currentHoldStart = $order->hold_started_at ?? $order->created_at;
            }

            if ($order->type === 'resume' && $currentHoldStart) {
                $resumeTime = $order->resumed_at ?? $order->created_at;
                $totalHoldDuration += $resumeTime->diffInSeconds($currentHoldStart);
                $currentHoldStart = null;
            }
        }

        $effectiveDuration = $endTime->diffInSeconds($startTime) - $totalHoldDuration;

        return response()->json([
            'effective_duration' => $effectiveDuration,
            'formatted_duration' => gmdate('H:i:s', $effectiveDuration),
        ]);
    }
}
