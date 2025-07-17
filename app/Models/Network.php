<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    /** @use HasFactory<\Database\Factories\NetworkFactory> */
    use HasFactory;
    
    protected $fillable = ['network_number', 'detail', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function asset()
    {
        return $this->hasOne(Asset::class);
    }
}
