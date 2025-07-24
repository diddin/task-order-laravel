<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'content', 'is_active', 'start_date', 'end_date'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
