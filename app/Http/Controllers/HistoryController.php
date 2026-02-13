<?php

namespace App\Http\Controllers;
use App\Models\HistoryLog;

class HistoryController extends Controller {
    public function index() { $logs = HistoryLog::latest()->paginate(20); return view('history.index', compact('logs')); }
}
