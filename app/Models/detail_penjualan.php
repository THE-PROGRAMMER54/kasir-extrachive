<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_penjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $hidden = [];
    protected $guarded = [];

    public function penjualan(){
        return $this->hasMany(penjualan::class);
    }
}
