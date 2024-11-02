<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'ship_to',
        'nomor_plat',
        'nama_driver',
        'palka',
        'status',
        'tanggal_sampai',
        'tanggal_bongkar',
        'print'
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'datetime',
        'tanggal_sampai' => 'datetime',
        'tanggal_bongkar' => 'datetime',
        'print' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Format: SJ-YYYYMM-INCREMENT
            // Contoh: SJ-202405-0001

            // Ambil nomor surat terbaru berdasarkan bulan dan tahun ini
            $latestDeliveryNote = static::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->latest()
                ->first();

            // Tentukan increment, mulai dari 1 jika belum ada nomor surat untuk bulan ini
            $increment = $latestDeliveryNote ? (int)substr($latestDeliveryNote->nomor_surat, -4) + 1 : 1;

            // Format nomor surat baru
            $model->nomor_surat = sprintf(
                'SJ-%s-%04d',
                now()->format('Ym'),
                $increment
            );
        });
    }


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
