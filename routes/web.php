<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

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
    // マイ予約一覧
    Route::get('/my/reservations', [ReservationController::class, 'myIndex'])->name('my.reservations.index');


    // ▼▼▼ 管理者向け機能 ▼▼▼
    Route::prefix('admin')->name('admin.')->middleware('can:admin-only')->group(function () {
        Route::resource('users', UserController::class);


        // 承認済み予約の一覧表示
        Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');

        // 貸出実行処理
        Route::post('/reservations/{reservation}/lend', [AdminReservationController::class, 'lend'])->name('reservations.lend');


        Route::prefix('approvals')->name('approvals.')->group(function () {
            Route::get('/', [ApprovalController::class, 'index'])->name('index');
            // 詳細画面
            Route::get('/{change_request}', [ApprovalController::class, 'show'])->name('show');
            // 承認処理
            Route::post('/{change_request}/approve', [ApprovalController::class, 'approve'])->name('approve');
            // 却下処理
            Route::post('/{change_request}/reject', [ApprovalController::class, 'reject'])->name('reject');
        });
    });
});


require __DIR__ . '/auth.php';
