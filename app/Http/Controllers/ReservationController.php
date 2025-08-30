<?php

namespace App\Http\Controllers;

use DragonCode\Contracts\Cache\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReservationRequest;
use App\Models\ChangeRequest;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;



class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Equipment $equipment)
    {
        return view('reservations.create', compact('equipment'));
    }

    /**
     * 予約申請をchange_requestsテーブルに保存する
     */
    public function store(StoreReservationRequest $request)
    {
        // この時点でバリデーションは成功している
        $validated = $request->validated();

        // change_requestsテーブルに、新しい「予約申請」レコードを作成する
        ChangeRequest::create([
            'user_id' => Auth::id(), // 申請者ID
            'target_model' => Equipment::class, // 申請対象のモデル名
            'target_id' => $validated['equipment_id'], // 申請対象の備品ID
            'type' => 'create_reservation', // 申請の種類を「予約作成」とする
            'payload_after' => json_encode([ // 申請内容の詳細をJSON形式で保存
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]),
        ]);

        // 申請完了後は、マイ予約一覧などにリダイレクトするのが親切
        return redirect()->route('my.reservations.index')->with('success', '予約申請を送信しました。');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function myIndex()
    {
        $myChangeRequests = ChangeRequest::where('user_id', Auth::id())
            ->where('type', 'create_reservation')
            ->latest()
            ->get();

        return view('reservations.my-index', compact('myChangeRequests'));
    }
}
