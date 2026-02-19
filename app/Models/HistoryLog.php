<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistoryLog extends Model
{
    protected $guarded = [];

    // Helper untuk catat log simple
    public static function record($action, $description)
    {
        self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description
        ]);
    }

    // Relasi ke User (Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
