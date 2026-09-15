<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = ['name', 'unit_id', 'price', 'stok'];

    public function unit()
    {
        return $this->belongsTo(Satuan::class, 'unit_id', 'id');
    }
}
