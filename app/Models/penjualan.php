<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $table = 'penjualan';
    protected $hidden = [];
    protected $guarded = [];

    public function barang(){
        return $this->hasMany(barang::class);
    }
}
