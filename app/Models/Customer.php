<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, SoftDeletes;

    // protected $fillable = ['name', 'address'];
    protected $fillable = [
        'name',
        'address',
        'network_number',
        'contact_person',
        'category',
        'cluster',
        'pic',
        'technical_data',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public static function backboneCustomer(): ?Customer
    {
       return self::where('category', 'backbone')->first();
    } // $backboneCustomer = Customer::backboneCustomer();
}
