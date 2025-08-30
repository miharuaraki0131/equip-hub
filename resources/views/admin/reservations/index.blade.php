{{-- resources/views/admin/reservations/index.blade.php --}}
<x-portal-layout>
    <div class="bg-white p-6 md:p-8 rounded-xl shadow-md space-y-8">

        {{-- フラッシュメッセージ --}}
        <x-flash-message />

        {{-- =============================================== --}}
        {{-- 貸出待リスト --}}
        {{-- =============================================== --}}
        <div>
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">
                    貸出待ちの予約
                </h1>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">申請者</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">備品名</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">貸出期間</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pendingLendReservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->equipment->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($reservation->start_date)->format('Y/m/d') }} - {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y/m/d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.reservations.lend', $reservation) }}" method="POST" onsubmit="return confirm('この備品を貸し出しますか？');">
                                        @csrf
                                        <button type="submit" class="btn-primary">貸出実行</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">貸出待ちの予約はありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- =============================================== --}}
        {{-- 現在貸出中の備品リスト --}}
        {{-- =============================================== --}}
        <div>
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">
                    現在貸出中の備品
                </h1>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">利用者</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">備品名</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">返却期限</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($lendingReservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->equipment->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold {{ now()->gt($reservation->end_date) ? 'text-red-600' : '' }}">
                                    {{ \Carbon\Carbon::parse($reservation->end_date)->format('Y/m/d') }}
                                    @if(now()->gt($reservation->end_date))
                                        <span class="text-xs ml-1">(期限超過)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.reservations.return', $reservation) }}" method="POST" onsubmit="return confirm('この備品を返却済みにしますか？');">
                                        @csrf
                                        <button type="submit" class="btn-secondary">返却処理</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">現在貸出中の備品はありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-portal-layout>
