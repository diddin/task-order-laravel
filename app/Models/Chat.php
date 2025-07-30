<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Chat extends Model
{
    use HasFactory;

    public $timestamps = false; // Karena hanya menggunakan created_at saja

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'created_at',
        'is_read',
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

    // Scope: hanya yang belum dibaca
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('is_read', false);
    }

    // Scope: filter chat masuk ke user tertentu
    public function scopeForUser(Builder $query, $userId): Builder
    {
        return $query->where('to_user_id', $userId);
    }

    // Scope: filter chat masuk dari user tertentu
    public function scopeFromUser(Builder $query, $userId): Builder
    {
        return $query->where('from_user_id', $userId);
    }
}
