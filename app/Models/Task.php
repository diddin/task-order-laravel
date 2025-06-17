<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'detail', 'network_id', 'assigned_to', 'created_by', 'action',
    ];

    // Relasi ke Network
    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    // User yang ditugaskan (nullable)
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
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

    
}
