<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CylinderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HistoryController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () { return redirect()->route('login'); });
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');

    // Transaksi
    Route::post('/transaction/rent', [TransactionController::class, 'store'])->name('transaction.store');
    Route::put('/transaction/return/{id}', [TransactionController::class, 'returnCylinder'])->name('transaction.return');
    Route::post('/transaction/{id}/swap', [TransactionController::class, 'swap'])->name('transaction.swap');

    Route::resource('clients', ClientController::class);
    Route::resource('cylinders', CylinderController::class);

    // --- AREA MANAJEMEN PABRIK (PENGISIAN MASSAL) ---
    Route::get('/factory', [CylinderController::class, 'factoryIndex'])->name('cylinders.factory');
    Route::post('/factory/send', [CylinderController::class, 'sendToFactory'])->name('cylinders.send_factory');
    Route::post('/factory/receive', [CylinderController::class, 'receiveFromFactory'])->name('cylinders.receive_factory');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});
