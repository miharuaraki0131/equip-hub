<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * 承認済み（貸出待ち）の予約一覧を表示する
     */
    public function index()
    {
        // statusが20（承認済/貸出待）の予約を、関連するユーザーと備品情報と共に取得
        $pendingLendReservations = Reservation::with(['user', 'equipment'])
            ->where('status', 20) // 貸出待ちの予約に絞る
            ->orderBy('start_date', 'asc') // 貸出開始日が近い順に並べる
            ->paginate(10); // 10件ごとにページネーション

        return view('admin.reservations.index', compact('pendingLendReservations'));
    }

    /**
     * 備品を貸し出し済みにする処理
     */
    public function lend(Reservation $reservation)
    {
        // すでに貸出中や返却済みの場合は、何もしない（二重実行防止）
        if ($reservation->status !== 20) {
            return redirect()->back()->with('error', 'この予約は貸出待ちの状態ではありません。');
        }

        // トランザクション処理で、データの整合性を担保する
        DB::transaction(function () use ($reservation) {
            // 1. 予約テーブルのステータスを「貸出中」に更新し、貸出日時を記録
            $reservation->status = 30; // 30: 貸出中
            $reservation->rented_at = Carbon::now();
            $reservation->save();

            // 2. 備品マスタのステータスを「貸出中」に更新
            $equipment = $reservation->equipment;
            $equipment->status = 20; // 20: 貸出中
            $equipment->save();
        });

        return redirect()->back()->with('success', $reservation->equipment->name . ' を ' . $reservation->user->name . ' に貸し出しました。');
    }
}
