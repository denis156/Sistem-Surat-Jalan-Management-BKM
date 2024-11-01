<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_note_id', 'name_item', 'quantity', 'description'
    ];

    public function deliveryNote()
    {
        return $this->belongsTo(DeliveryNote::class);
    }
}
