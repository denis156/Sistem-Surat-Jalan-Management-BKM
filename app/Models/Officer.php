<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Officer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_id',
        'type',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryNotes()
    {
        return $this
            ->hasMany(DeliveryNote::class, 'field_officer_id')
            ->orWhere('room_officer_id', $this->id)
            ->orWhere('warehouse_officer_id', $this->id);
    }
}
