<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'id');
    }
}
