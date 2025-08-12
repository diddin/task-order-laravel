<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'task_number',
        'detail',
        'customer_id',
        'task_number',
        'created_by',
        'action', // ['in progress', 'completed'])->nullable()
        'category',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        //     static::created(function ($task) {
        //         $year = now()->year;
        //         $formattedId = str_pad($task->id, 9, '0', STR_PAD_LEFT);
        //         $task->task_number = "{$year}-{$formattedId}";
        //         $task->save();
        //     });
        static::updating(function ($task) {
            // Jika sebelumnya bukan "completed" dan sekarang jadi "completed"
            if ($task->isDirty('action') && $task->action === 'completed') {
                $task->completed_at = now();
            }

            // Jika sebelumnya "completed" lalu diubah kembali jadi "in progress", kosongkan
            if ($task->isDirty('action') && $task->action !== 'completed') {
                $task->completed_at = null;
            }
        });
    }
    
    // Relasi ke Customer New
    public function customer()
    {
        return $this->belongsTo(Customer::class);
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

    public function getDurationAttribute()
    {
        if ($this->completed_at) {
            $diff = $this->created_at->diff($this->completed_at);
            return "{$diff->d} hari {$diff->h} jam {$diff->i} menit";
        }
        return null;
    }
    
}
