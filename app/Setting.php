<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
    protected $fillable = ['key', 'value'];

    public function products()
    {
        return $this->hasMany(Produk::class, 'unit_id', 'id');
    }
}
