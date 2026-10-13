<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = ['name', 'unit_id', 'kategori_id', 'price', 'sell', 'stok'];

    public function unit()
    {
        return $this->belongsTo(Satuan::class, 'unit_id', 'id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
