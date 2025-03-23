<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_penjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $hidden = [];
    protected $guarded = [];

    public function penjualan(){
        return $this->belongsTo(penjualan::class,'id_penjualan','id_penjualan');
    }

    public function barang(){
        return $this->belongsTo(barang::class,'kode_barang','kode_barang');
    }
}
