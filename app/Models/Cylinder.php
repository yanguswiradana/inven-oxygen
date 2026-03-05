<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cylinder extends Model
{
    use HasFactory;

    protected $fillable = ['serial_number', 'type', 'status'];

    // Relasi ke semua transaksi
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    // FUNGSI BARU: Mengambil 1 transaksi yang sedang aktif (open) saat ini
    public function activeTransaction() {
        return $this->hasOne(Transaction::class)->where('status', 'open')->latestOfMany();
    }
}
