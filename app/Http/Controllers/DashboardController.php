<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\ChangeRequest;
use App\Models\Reservation; // 貸出履歴を扱うReservationモデル
use App\Models\Category;    // カテゴリ名を取得するためにCategoryモデル
use Illuminate\Support\Facades\DB; // DBファサードを利用
use Carbon\Carbon; // 日付操作のためにCarbonを利用

class DashboardController extends Controller
{
    public function index()
    {
        // --- サマリーカード用のデータ ---
        $pendingApprovalsCount = ChangeRequest::where('status', 10)->count();
        $rentedEquipmentsCount = Equipment::where('status', 20)->count();
        $availableEquipmentsCount = Equipment::where('status', 10)->count();

        // --- ① カテゴリ別貸出比率グラフ用のデータ ---
        // equipmentsテーブルをcategoriesテーブルと結合(join)し、
        // カテゴリ名(categories.name)でグループ化(groupBy)して、備品数(count)を集計。
        $categoryCounts = Category::join('equipments', 'categories.id', '=', 'equipments.category_id')
            ->select('categories.name', DB::raw('count(equipments.id) as count')) // カテゴリ名とカテゴリごとの備品数(count というエイリアス)を取得
            ->groupBy('categories.name')
            ->pluck('count', 'name'); // 結果を ['カテゴリ名' => '件数'] の連想配列で取得 指定したものだけを配列として取得

        // Chart.jsで使いやすいように、ラベルとデータに分離する
        $categoryLabels = $categoryCounts->keys();
        $categoryData = $categoryCounts->values();


        // --- ② 月別貸出トレンドグラフ用のデータ ---
        // reservationsテーブルから、過去12ヶ月のデータを月別に集計します。
        $monthlyRentals = Reservation::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), // created_atを「年-月」の形式にフォーマット
            DB::raw('count(id) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(12)) // 12ヶ月前からのデータに絞る
            ->groupBy('month')
            ->orderBy('month', 'asc') // 月で昇順に並べる
            ->pluck('count', 'month'); // 結果を ['2025-01' => '件数'] の形式で取得

        // Chart.jsで使いやすいように、ラベルとデータに分離する
        $monthlyLabels = $monthlyRentals->keys();
        $monthlyData = $monthlyRentals->values();


        // --- データをビューに渡す ---
        return view('dashboard', [
            // サマリーカード用
            'pendingApprovalsCount' => $pendingApprovalsCount,
            'rentedEquipmentsCount' => $rentedEquipmentsCount,
            'availableEquipmentsCount' => $availableEquipmentsCount,

            // カテゴリ別グラフ用
            'categoryLabels' => $categoryLabels,
            'categoryData' => $categoryData,

            // 月別トレンドグラフ用
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
        ]);
    }
}
