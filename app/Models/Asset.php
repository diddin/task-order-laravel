<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    use HasFactory;

    protected $fillable = [
        'validation_date',
        'data_collection_time',
        'location',
        'code',
        'name',
        'label',
        'object_type',
        'construction_location',
        'potential_problem',
        'improvement_recomendation',
        'detail_improvement_recomendation',
        'pop',
        'olt',
        'number_of_ports',
        // 'number_of_registered_ports', // Hapus ini jika ingin pakai accessor
        'number_of_registered_labels',
        'network_id',
    ];

    public function images()
    {
        return $this->hasMany(AssetImage::class);
    }

    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    public function ports()
    {
        return $this->hasMany(AssetPort::class);
    }

    // accessor
    public function getNumberOfRegisteredPortsAttribute()
    {
        return $this->ports()->whereNotNull('jumper_id')->count();
    }
        
}
