<x-portal-layout :showHero="false">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            申請内容の確認
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- 左カラム：申請内容カード --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6 md:p-8">
                            {{-- ヘッダー --}}
                            <div class="flex justify-between items-center">
                                <h1 class="text-2xl font-bold text-gray-800">
                                    予約申請内容
                                </h1>
                                {!! $changeRequest->status_badge !!}
                            </div>
                            <p class="text-sm text-gray-500 mt-1">申請ID: #{{ $changeRequest->id }}</p>
                        </div>

                        {{-- 申請内容 --}}
                        <div class="border-t border-gray-200 px-6 md:px-8 py-6 space-y-6">
                            {{-- 対象備品 --}}
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-indigo-500 mt-1 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">対象備品</h3>
                                    <p class="text-gray-600 mt-1">{{ $changeRequest->targetable->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- 希望期間 --}}
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-indigo-500 mt-1 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">希望利用期間</h3>
                                    @php
                                        $payload = json_decode($changeRequest->payload_after, true);
                                    @endphp
                                    <p class="text-gray-600 mt-1">
                                        <span
                                            class="font-semibold">{{ \Carbon\Carbon::parse($payload['start_date'])->format('Y年m月d日') }}</span>
                                        <span class="mx-2 text-gray-400">〜</span>
                                        <span
                                            class="font-semibold">{{ \Carbon\Carbon::parse($payload['end_date'])->format('Y年m月d日') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- アクションボタン --}}
                        @if ($changeRequest->status == 10)
                            <div class="bg-gray-50 px-6 py-4 flex justify-end items-center gap-4">
                                <form action="{{ route('admin.approvals.reject', $changeRequest) }}" method="POST"
                                    onsubmit="return confirm('本当にこの申請を却下しますか？');">
                                    @csrf
                                    <button type="submit"
                                        class="font-semibold text-gray-600 hover:text-red-600 transition-colors duration-200">
                                        却下
                                    </button>
                                </form>
                                <form action="{{ route('admin.approvals.approve', $changeRequest) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-transform transform hover:scale-105">
                                        この内容で承認する
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg">

                        {{-- ▼▼▼ カードヘッダー ▼▼▼ --}}
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800">
                                申請者情報
                            </h2>
                        </div>
                        {{-- ▲▲▲ カードヘッダー ▲▲▲ --}}

                        {{-- ▼▼▼ カードボディ ▼▼▼ --}}
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <img class="h-16 w-16 rounded-full object-cover"
                                    src="https://i.pravatar.cc/150?u={{ $changeRequest->user->email }}"
                                    alt="User Avatar">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $changeRequest->user->name ?? 'N/A' }}</h3>
                                    <p class="text-sm text-gray-500">{{ $changeRequest->user->division->name ?? '未設定' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 border-t pt-4 space-y-3 text-sm">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="ml-3 text-gray-600">{{ $changeRequest->user->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="ml-3 text-gray-600">過去の申請履歴: 5件</span>
                                </div>
                            </div>
                        </div>
                        {{-- ▲▲▲ カードボディ ▲▲▲ --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-portal-layout>
