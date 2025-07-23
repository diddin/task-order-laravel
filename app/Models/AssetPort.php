<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetPort extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'port', 'jumper_id'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function jumper()
    {
        return $this->belongsTo(AssetPort::class, 'jumper_id');
    }
}
