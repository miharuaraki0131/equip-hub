<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChangeRequest;

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


    public function show(ChangeRequest $change_request)
    {
        return view('admin.approvals.show', compact('change_request'));
    }
}
