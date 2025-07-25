<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'detail',
        'network_id',
        'created_by',
        'action', // ['in progress', 'completed'])->nullable()
    ];

    protected static function booted()
    {
        static::created(function ($task) {
            $year = now()->year;
            $formattedId = str_pad($task->id, 9, '0', STR_PAD_LEFT);
            $task->task_number = "{$year}-{$formattedId}";
            $task->save();
        });
    }

    // Relasi ke Network
    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    public function assignedUsers() {
        return $this->belongsToMany(User::class, 'task_user_assignment')
                    ->withPivot('role_in_task', 'is_read')
                    ->withTimestamps();
    }
    
    public function pic() {
        return $this->assignedUsers()->wherePivot('role_in_task', 'pic')->first();
    }
    
    public function onsiteTeam() {
        return $this->assignedUsers()->wherePivot('role_in_task', 'onsite')->get();
    }

    // Task::with(['picUsers', 'onsiteUsers'])->get();
    
    public function picUsers()
    {
        return $this->assignedUsers()->wherePivot('role_in_task', 'pic');
        // return $this->belongsToMany(User::class, 'task_user_assignment')
        //             ->withPivot('role_in_task')
        //             ->wherePivot('role_in_task', 'pic');
    }

    public function onsiteUsers()
    {
        return $this->assignedUsers()->wherePivot('role_in_task', 'onsite');
        // return $this->belongsToMany(User::class, 'task_user_assignment')
        //             ->withPivot('role_in_task')
        //             ->wherePivot('role_in_task', 'onsite');
    }

    // User yang membuat task
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(TaskOrder::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('assignedUsers', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeForPicUser($query, $userId)
    {
        return $query->whereHas('assignedUsers', function ($q) use ($userId) {
            $q->where('user_id', $userId)
            ->where('role_in_task', 'pic');
        });
    }

    public function scopeWithAction($query)
    {
        return $query->whereNotNull('action');
    }

    public function scopeWithoutAction($query)
    {
        return $query->whereNull('action');
    }
    
}
