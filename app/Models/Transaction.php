<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $guarded = [];
    protected $casts = ['rent_date' => 'datetime', 'return_date' => 'datetime'];

    public function client() { return $this->belongsTo(Client::class); }
    public function cylinder() { return $this->belongsTo(Cylinder::class); }
}
