<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    public $timestamps = false; // Karena hanya menggunakan created_at saja

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'created_at',
    ];

    // Relasi ke pengirim
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // Relasi ke penerima
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
