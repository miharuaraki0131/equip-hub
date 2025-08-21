<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証済みユーザーのみアクセス可能
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // resourceを使うことで index, create, store, show, edit, update, destroy を一括する
    Route::resource('equipments', EquipmentController::class);

    // 予約申請画面 (ルートモデルバインディングを有効にするため、パラメータ名を{equipment}にする)
    Route::get('/reservations/create/{equipment}', [ReservationController::class, 'create'])->name('reservations.create');

    // 予約のCRUD (createを除く)
    Route::resource('reservations', ReservationController::class)->except(['create']);

});



require __DIR__.'/auth.php';
