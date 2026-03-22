<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'material_id',
        'branch_id',
        'qty_change',
        'qty_before',
        'qty_after',
        'type',
        'reference_type',
        'reference_id',
        'created_by',
    ];
}
