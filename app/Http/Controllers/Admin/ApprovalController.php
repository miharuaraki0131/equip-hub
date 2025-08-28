<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChangeRequest;
use App\Models\Reservation; // ★Reservationモデルをuseする
use Illuminate\Support\Facades\DB; // ★DBをuseする
use App\Notifications\ReservationResultNotified;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingApprovals = ChangeRequest::where('type', 'create_reservation')
            ->where('status', 10)
            ->with('user', 'targetable') // ★Eager Loadingでパフォーマンス最適化！
            ->latest()
            ->paginate(15); // 一覧なのでpaginateが適切

        return view('admin.approvals.index', compact('pendingApprovals'));
    }


    public function show(ChangeRequest $changeRequest)
    {
        return view('admin.approvals.show', compact('changeRequest'));
    }


    public function approve(ChangeRequest $changeRequest)
    {
        DB::transaction(function () use ($changeRequest) {
            // 1. 申請内容(payload)を取得
            $payload = json_decode($changeRequest->payload_after, true);

            // 2. reservationsテーブルに、確定した予約レコードを作成
            Reservation::create([
                'user_id' => $changeRequest->user_id,
                'equipment_id' => $changeRequest->target_id,
                'start_date' => $payload['start_date'],
                'end_date' => $payload['end_date'],
                'status' => 20, // 20:承認済(貸出待)
            ]);

            // 3. change_requestsテーブルのステータスを「承認済み」に更新
            $changeRequest->status = 20;
            $changeRequest->save();
        });

        // 4. 申請者に通知
        $changeRequest->user->notify(new ReservationResultNotified($changeRequest, '承認'));
        return redirect()->route('admin.approvals.index')->with('success', '申請を承認しました。');
    }

    public function reject(ChangeRequest $changeRequest)
    {
        // 1. change_requestsテーブルのステータスを「却下」に更新
        $changeRequest->status = 30;
        $changeRequest->save();

        // 2. 申請者に通知
        $changeRequest->user->notify(new ReservationResultNotified($changeRequest, '却下'));

        return redirect()->route('admin.approvals.index')->with('success', '申請を却下しました。');
    }
}
