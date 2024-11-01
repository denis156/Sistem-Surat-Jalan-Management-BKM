<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'field_officer_id',
        'room_officer_id',
        'warehouse_officer_id',
        'client_id',
        'nomor_surat',
        'tanggal_pengiriman',
        'waktu_pengiriman',
        'ship_to',
        'nomor_plat',
        'nama_driver',
        'palka',
        'status',
        'tanggal_sampai',
        'waktu_sampai',
        'tanggal_bongkar',
        'waktu_bongkar',
        'print'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function fieldOfficer()
    {
        return $this->belongsTo(Officer::class, 'field_officer_id');
    }

    public function roomOfficer()
    {
        return $this->belongsTo(Officer::class, 'room_officer_id');
    }

    public function warehouseOfficer()
    {
        return $this->belongsTo(Officer::class, 'warehouse_officer_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
