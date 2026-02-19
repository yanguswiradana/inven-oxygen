<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cylinder extends Model
{
    protected $guarded = [];

    // Relasi: Satu Tabung punya banyak riwayat Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
