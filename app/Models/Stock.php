<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'material_id',
        'branch_id',
        'qty',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
