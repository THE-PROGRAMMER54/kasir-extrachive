<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasUuids;
    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    public $keyType = 'string';
    protected $hidden = [];
    protected $guarded = [];

    public function detail_penjualan(){
        return $this->hasMany(detail_penjualan::class, 'kode_barang','kode_barang');
    }
}
