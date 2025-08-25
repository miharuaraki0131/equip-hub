<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Requests\EquipmentRequest;
use App\Models\Category;
use App\Models\Division;


class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // ▼▼▼ 引数に Request $request を追加 ▼▼▼
    public function index(Request $request)
    {
        // 1. ベースとなるクエリビルダを準備する
        //    (これまで通り、N+1問題対策の with() もここに入れる)
        $query = Equipment::with('category', 'division');

        // 2. もしURLに 'status=available' が付いていたら、絞り込み条件を追加する
        if ($request->query('status') === 'available') {
            // statusカラムが 10 (利用可) のものだけに絞り込む
            $query->where('status', 10);
        }elseif ($request->query('status') === 'rent') {
            // statusカラムが 20 (貸出中) のものだけに絞り込む
            $query->where('status', 20);
        }

        // 3. 最終的なクエリに対して、並び順とページネーションを適用して、データを取得する
        $equipments = $query->latest()->paginate(10);

        // 4. ビューにデータを渡す
        return view('equipments.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $divisions = Division::all();
        return view('equipments.create', compact('categories', 'divisions'));
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
        $categories = Category::all();
        $divisions = Division::all();
        return view('equipments.edit', compact('equipment', 'categories', 'divisions'));
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
