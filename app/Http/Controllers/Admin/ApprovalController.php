<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChangeRequest;
use App\Models\Reservation; // ★Reservationモデルをuseする
use Illuminate\Support\Facades\DB; // ★DBをuseする

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingApprovals = ChangeRequest::where('type', 'create_reservation')
            // ->where('status', 10) // 将来的にstatusカラムで絞り込む
            ->with('user', 'targetable') // ★Eager Loadingでパフォーマンス最適化！
            ->latest()
            ->paginate(15); // 一覧なのでpaginateが適切

        return view('admin.approvals.index', compact('pendingApprovals'));
    }


    public function show(ChangeRequest $changeRequest)
    {
        return view('admin.approvals.show', compact('changeRequest'));
    }


    public function approve(ChangeRequest $change_request)
    {
        DB::transaction(function () use ($change_request) {
            // 1. 申請内容(payload)を取得
            $payload = json_decode($change_request->payload_after, true);

            // 2. reservationsテーブルに、確定した予約レコードを作成
            Reservation::create([
                'user_id' => $change_request->user_id,
                'equipment_id' => $change_request->target_id,
                'start_date' => $payload['start_date'],
                'end_date' => $payload['end_date'],
                'status' => 20, // 20:承認済(貸出待)
            ]);

            // 3. change_requestsテーブルのステータスを「承認済み」に更新
            $change_request->status = 20;
            $change_request->save();
        });

        return redirect()->route('admin.approvals.index')->with('success', '申請を承認しました。');
    }

    public function reject(ChangeRequest $change_request)
    {
        // 1. change_requestsテーブルのステータスを「却下」に更新
        $change_request->status = 30;
        $change_request->save();

        return redirect()->route('admin.approvals.index')->with('success', '申請を却下しました。');
    }
}
