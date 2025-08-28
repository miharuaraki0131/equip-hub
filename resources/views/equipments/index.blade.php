<x-portal-layout :showHero="false"> {{-- ダッシュボード以外のページではヒーローは非表示 --}}

    {{-- =============================================== --}}
    {{-- メインコンテンツ --}}
    {{-- =============================================== --}}
    <div class="bg-[var(--card-bg)] p-6 md:p-8 rounded-xl shadow-md">

        {{-- ヘッダーエリア：タイトルとアクション --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

            {{-- 左側：ページタイトル --}}
            <h1 class="text-2xl font-bold text-gray-800">
                備品一覧
            </h1>

            {{-- 右側：検索フォームと新規登録ボタンのグループ --}}
            <div class="flex items-center gap-x-4">

                {{-- 検索・ソートフォーム --}}
                <form action="{{ route('equipments.index') }}" method="GET" class="flex items-center gap-x-2">
                    {{-- キーワード検索 --}}
                    <div class="relative">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="キーワード検索"
                            class="form-input rounded-full pl-10 pr-4 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    {{-- 並び替え --}}
                    <div>
                        <select name="sort_by" onchange="this.form.submit()"
                            class="form-select rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 transition text-sm">
                            <option value="latest" {{ request('sort_by', 'latest') == 'latest' ? 'selected' : '' }}>新しい順
                            </option>
                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>古い順</option>
                            <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>名前 (昇順)
                            </option>
                            <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>名前 (降順)
                            </option>
                        </select>
                    </div>
                </form>

                {{-- 新規登録ボタン --}}
                <a href="{{ route('equipments.create') }}" class="btn-primary whitespace-nowrap">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z">
                        </path>
                    </svg>
                    <span>新規登録</span>
                </a>

            </div>
        </div>

        {{-- 備品一覧テーブル --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">備品名
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">カテゴリ
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">管理部署
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">状態
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">編集</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($equipments as $equipment)
                        <tr class="hover:bg-gray-100 transition-colors duration-100">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $equipment->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $equipment->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $equipment->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $equipment->division->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $equipment->status_text }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-x-4">

                                    {{-- 編集ボタン --}}
                                    <a href="{{ route('equipments.edit', $equipment) }}"
                                        class="px-3 py-1 text-sm font-semibold text-white bg-gray-600 rounded-md shadow-sm hover:bg-gray-700 transition-colors">
                                        編集
                                    </a>

                                    {{-- 削除ボタン --}}
                                    <form action="{{ route('equipments.destroy', $equipment) }}" method="POST"
                                        onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 transition-colors">
                                            削除
                                        </button>
                                    </form>

                                    {{-- 予約するボタン（状態に応じて動的に変化） --}}
                                    @if ($equipment->status == 10)
                                        {{-- 10: 利用可 --}}
                                        {{-- ★★★ 活性状態のボタン ★★★ --}}
                                        <a href="{{ route('reservations.create', $equipment) }}"
                                            class="px-3 py-1 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 transition-colors">
                                            予約する
                                        </a>
                                    @else
                                        {{-- ★★★ 非活性状態のボタン ★★★ --}}
                                        <button type="button"
                                            class="px-3 py-1 text-sm font-semibold text-white bg-gray-300 rounded-md shadow-sm cursor-not-allowed"
                                            disabled>
                                            予約不可
                                        </button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- ページネーションリンク --}}
        <div class="mt-6">
            {{ $equipments->links() }}
        </div>
    </div>
</x-portal-layout>
