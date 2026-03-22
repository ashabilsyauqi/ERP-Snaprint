<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'branch_id',
        'created_by',
        'total_amount',
        'status',
    ];

    // 🔗 RELATION

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}