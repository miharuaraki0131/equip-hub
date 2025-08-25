<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\ChangeRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingApprovalsCount = ChangeRequest::where('status', 10)->count();
        $rentedEquipmentsCount = Equipment::where('status', 20)->count(); // ← あなたが今実装したロジック！
        $availableEquipmentsCount = Equipment::where('status', 10)->count();

        return view('dashboard', [
            'pendingApprovalsCount' => $pendingApprovalsCount,
            'rentedEquipmentsCount' => $rentedEquipmentsCount,
            'availableEquipmentsCount' => $availableEquipmentsCount,
        ]);
    }
}
