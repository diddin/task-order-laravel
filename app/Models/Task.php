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
        'action',
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
                    ->withPivot('role_in_task')
                    ->withTimestamps();
    }
    
    public function pic() {
        // return $this->assignedUsers()->wherePivot('role_in_task', 'pic');
        return $this->assignedUsers()->wherePivot('role_in_task', 'pic')->first();
    }
    
    public function onsiteTeam() {
        //return $this->assignedUsers()->wherePivot('role_in_task', 'onsite');
        return $this->assignedUsers()->wherePivot('role_in_task', 'onsite')->get();
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
        return $query->where('assigned_to', $userId);
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
