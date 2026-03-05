<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Di sinilah kita mendaftarkan 'category' agar diizinkan untuk diisi data
    protected $fillable = [
        'client_id',
        'cylinder_id',
        'category', // <--- TAMBAHAN BARUNYA DI SINI
        'rent_date',
        'return_date',
        'status'
    ];

    protected $casts = [
        'rent_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function cylinder() {
        return $this->belongsTo(Cylinder::class);
    }
}
