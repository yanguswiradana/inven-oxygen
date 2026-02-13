<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistoryLog extends Model {
    protected $guarded = [];

    public static function record($action, $description) {
        self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description
        ]);
    }
}
