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

    protected static function boot()
    {
        parent::boot();

        // Event untuk mengisi employee_id saat Officer dibuat
        static::creating(function ($officer) {
            if (empty($officer->employee_id)) {
                $officer->employee_id = 'BKM-' . str_pad(Officer::max('id') + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan DeliveryNote sebagai field officer
    public function fieldDeliveryNotes()
    {
        return $this->hasMany(DeliveryNote::class, 'field_officer_id');
    }

    // Relasi dengan DeliveryNote sebagai room officer
    public function roomDeliveryNotes()
    {
        return $this->hasMany(DeliveryNote::class, 'room_officer_id');
    }

    // Relasi dengan DeliveryNote sebagai warehouse officer
    public function warehouseDeliveryNotes()
    {
        return $this->hasMany(DeliveryNote::class, 'warehouse_officer_id');
    }
}
