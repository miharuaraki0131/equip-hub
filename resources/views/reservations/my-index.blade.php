<x-portal-layout :showHero="false"> {{-- ヒーローセクションは非表示 --}}

    {{-- =============================================== --}}
    {{-- メインコンテンツ --}}
    {{-- =============================================== --}}
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-md">

        {{-- ヘッダーエリア：タイトル --}}
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">
                マイ予約申請一覧
            </h1>
        </div>

        {{-- 申請一覧テーブル --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            申請ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            申請対象の備品
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            申請日
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            希望利用期間
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ステータス
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">操作</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($myChangeRequests as $changeRequest)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $changeRequest->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{-- targetableリレーションで備品名を取得 (要モデル修正) --}}
                                {{ $changeRequest->targetable->name ?? '（削除された備品）' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $changeRequest->created_at->format('Y/m/d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    // payload_afterはJSONなのでデコードして使う
                                    $payload = json_decode($changeRequest->payload_after, true);
                                @endphp
                                {{ $payload['start_date'] ?? 'N/A' }} ~ {{ $payload['end_date'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{-- status_badgeアクセサでステータス表示を生成 (要モデル修正) --}}
                                {!! $changeRequest->status_badge !!}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- 将来的に「申請取り消し」ボタンなどをここに設置 --}}
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">詳細</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                申請履歴はまだありません。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ページネーションが必要な場合はここに表示 --}}
        {{-- <div class="mt-6">
            {{ $myChangeRequests->links() }}
        </div> --}}

    </div>

</x-portal-layout>
