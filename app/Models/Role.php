<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ROLE_MASTER = 1;
    public const ROLE_ADMIN = 2;
    public const ROLE_TECHNICIAN = 3;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
