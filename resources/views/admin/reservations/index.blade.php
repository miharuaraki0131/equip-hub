{{-- resources/views/admin/reservations/index.blade.php --}}
<x-portal-layout>
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">
                承認済み予約一覧（貸出待）
            </h1>
        </div>

        {{-- フラッシュメッセージ --}}
        <x-flash-message />

        {{-- 申請一覧テーブル --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            申請者</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            備品名</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            貸出期間</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pendingLendReservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->equipment->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($reservation->start_date)->format('Y/m/d') }} -
                                {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y/m/d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- 貸出実行ボタン --}}
                                <form action="{{ route('admin.reservations.lend', $reservation) }}" method="POST"
                                    onsubmit="return confirm('この備品を貸し出しますか？');">
                                    @csrf
                                    <button type="submit" class="btn-primary">貸出実行</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                貸出待ちの予約はありません。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pendingLendReservations->links() }}
        </div>
    </div>
</x-portal-layout>
