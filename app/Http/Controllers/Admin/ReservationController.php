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
     * 貸出待ち、および貸出中の予約一覧を表示する
     */
    public function index()
    {
        // statusが20（貸出待ち）の予約を取得
        $pendingLendReservations = Reservation::with(['user', 'equipment'])
            ->where('status', 20)
            ->whereHas('user')
            ->whereHas('equipment')
            ->orderBy('start_date', 'asc')
            ->get(); // paginateではなくgetに変更

        // statusが30（貸出中）の予約を取得
        $lendingReservations = Reservation::with(['user', 'equipment'])
            ->where('status', 30)
            ->whereHas('user')
            ->whereHas('equipment')
            ->orderBy('end_date', 'asc')
            ->get();

        // 2種類のデータを、連想配列としてビューに渡す
        return view('admin.reservations.index', [
            'pendingLendReservations' => $pendingLendReservations,
            'lendingReservations' => $lendingReservations,
        ]);
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

    /**
     * 備品を返却済みにする処理
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function return(Reservation $reservation)
    {
        // すでに返却済みなどの場合は、何もしない（二重実行防止）
        if ($reservation->status !== 30) {
            return redirect()->back()->with('error', 'この予約は貸出中の状態ではありません。');
        }

        // トランザクション処理で、データの整合性を担保する
        DB::transaction(function () use ($reservation) {
            // 1. 予約テーブルのステータスを「返却済」に更新し、返却日時を記録
            $reservation->status = 40; // 40: 返却済
            $reservation->returned_at = Carbon::now();
            $reservation->save();

            // 2. 備品マスタのステータスを「利用可」に戻す
            $equipment = $reservation->equipment;
            $equipment->status = 10; // 10: 利用可
            $equipment->save();
        });

        return redirect()->back()->with('success', $reservation->equipment->name . 'が返却されました。');
    }
}
