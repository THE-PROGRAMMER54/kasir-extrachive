<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasUuids;
    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    protected $hidden = [];
    protected $guarded = [];

    public function penjualan(){
        return $this->belongsTo(penjualan::class);
    }
}
