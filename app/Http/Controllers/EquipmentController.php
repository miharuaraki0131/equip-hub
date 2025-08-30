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
   public function index(Request $request)
{
    $query = Equipment::with('category', 'division');

    // --- 検索ロジック ---
    if ($request->filled('keyword')) {
        $keyword = '%' . $request->input('keyword') . '%';
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', $keyword)
              ->orWhere('description', 'like', $keyword);
        });
    }

    // --- ステータス絞り込みロジック ---
    if ($request->query('status') === 'available') {
        $query->where('status', 10);
    } elseif ($request->query('status') === 'rent') {
        $query->where('status', 20);
    }

    // --- ソート（並び替え）ロジック ---
    $sortBy = $request->input('sort_by', 'latest');
    // ... switch文 ...
    switch ($sortBy) {
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
        default: // 'latest'
            $query->orderBy('created_at', 'desc');
            break;
    }

    $equipments = $query->paginate(10)->withQueryString();

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
