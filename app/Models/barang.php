<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    protected $table = 'barang';
    protected $hidden = [];
    protected $guarded = [];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function penjualan(){
        return $this->belongsTo(penjualan::class);
    }
}
