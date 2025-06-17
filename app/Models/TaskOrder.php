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
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
