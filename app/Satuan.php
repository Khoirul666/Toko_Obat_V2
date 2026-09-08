<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Produk::class, 'unit_id', 'id');
    }
}
