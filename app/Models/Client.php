<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // TAMBAHAN BARU

class Client extends Model {
    use HasFactory, SoftDeletes; // AKTIFKAN SOFT DELETES
    protected $fillable = ['name', 'phone', 'address'];
    public function transactions() { return $this->hasMany(Transaction::class); }
}
