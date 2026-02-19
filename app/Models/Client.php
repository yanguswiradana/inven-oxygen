<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    // Relasi: Satu Client punya banyak Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
