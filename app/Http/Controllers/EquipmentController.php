<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Requests\EquipmentRequest;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Equipmentsを取得するときにCategoryとDivisionを一緒に取得（N+1問題回避）
        $equipments = Equipment::with('category', 'division')->latest()->paginate(10); // paginateで全件取得回避
        return view('equipments.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request)
    {
        $validated = $request->validated();
         // ファイルアップロード処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('equipments', 'public');
            $validated['image_path'] = $path;
        }

        // データの保存
        $validated['status'] = 10; // 10:貸出可能 フォームにはないので追加
        Equipment::create($validated);

        return to_route('equipments.index')->with('success', '備品を登録しました。');
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
    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipmentRequest $request, Equipment $equipment)
    {
        $validated = $request->validated();
        // ファイルアップロード処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('equipments', 'public');
            $validated['image_path'] = $path;
        }

        $equipment->update($validated);
        return to_route('equipments.index')->with('success', '備品を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return to_route('equipments.index')->with('success', '備品を削除しました。');
    }
}
