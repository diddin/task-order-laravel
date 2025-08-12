<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskOrder extends Model
{
    /** @use HasFactory<\Database\Factories\TaskOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'status',
        'image',
        'latitude',
        'longitude',
        'type',              // ← tambahan
        'hold_started_at',   // ← tambahan
        'resumed_at',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
