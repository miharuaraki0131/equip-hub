{{-- resources/views/layouts/portal-navigation.blade.php --}}
<nav class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center relative z-30">
    <a class="text-3xl font-black tracking-wider" href="{{ route('dashboard') }}">EquipHub</a>

    {{-- 中央の検索エリア --}}
    <div class="hidden lg:flex items-center gap-4 relative">
        <div class="relative">
            <input class="input-search pl-10" placeholder="備品を検索..." type="search" />
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-white/70 pointer-events-none"
                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd"
                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                    fill-rule="evenodd"></path>
            </svg>
        </div>
    </div>

    {{-- 右側のユーザーメニュー --}}
    <div class="flex items-center gap-4">
        {{-- 通知ボタン --}}
        <button class="relative p-2 rounded-full hover:bg-white/10 transition-colors">
            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                    stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{-- 通知バッジ（未読がある場合） --}}
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
        </button>

        {{-- ユーザードロップダウンメニュー --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center gap-2 text-white font-medium hover:text-white/80 transition-colors">
                <span class="hidden sm:inline">ようこそ、{{ Auth::user()->name }} さん</span>
                <span class="sm:hidden">{{ Auth::user()->name }}</span>
                <svg class="h-5 w-5 transition-transform duration-200"
                    :class="{ 'rotate-180': open }"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            {{-- ドロップダウンの中身 --}}
            <div x-show="open"
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-from="transform opacity-0 scale-95"
                x-transition:enter-to="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-from="transform opacity-100 scale-100"
                x-transition:leave-to="transform opacity-0 scale-95"
                class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0">
                <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        プロフィール
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
