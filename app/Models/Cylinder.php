<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // TAMBAHAN BARU

class Cylinder extends Model {
    use HasFactory, SoftDeletes; // AKTIFKAN SOFT DELETES
    protected $fillable = ['serial_number', 'type', 'status'];
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function activeTransaction() { return $this->hasOne(Transaction::class)->where('status', 'open')->latestOfMany(); }
}
