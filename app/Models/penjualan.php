<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    protected $table = 'penjualan';
    protected $hidden = [];
    protected $guarded = [];
    protected $primaryKey = 'id_penjualan';
    public $incrementing = false;
    protected $keyType = 'string';

    public function barang(){
        return $this->hasMany(barang::class);
    }

    public function detail_penjualan(){
        return $this->belongsTo(detail_penjualan::class);
    }
}
