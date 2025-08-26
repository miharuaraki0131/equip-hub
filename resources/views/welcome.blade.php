<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EquipHub - チームのための、スマート・ポータル</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white text-gray-800">

    {{-- ヒーローセクション全体 --}}
    <div class="relative bg-gray-800 overflow-hidden">
        {{-- 背景画像 --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/header-background.jpg') }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60"></div> {{-- 少し暗くして文字を読みやすく --}}
        </div>

        {{-- コンテンツ（ヘッダーとメイン） --}}
        <div class="relative z-10 h-[70vh] min-h-[500px] flex flex-col">
            {{-- ヘッダー --}}
            <header class="container mx-auto px-6 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-black text-white tracking-wider">EquipHub</h1>
                    <div class="hidden sm:flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="text-white font-medium hover:text-white/80 transition-colors">ログイン</a>
                        <a href="{{ route('register') }}"
                            class="bg-white text-blue-600 font-semibold px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                            無料で始める
                        </a>
                    </div>
                    {{-- スマホ用のハンバーガーメニュー（将来的な拡張用） --}}
                    <div class="sm:hidden">
                        <button class="text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            {{-- ヒーローのメインコンテンツ --}}
            <main
                class="flex-grow container mx-auto px-6 text-center text-white flex flex-col items-center justify-center">
                <h2 class="text-4xl md:text-6xl font-bold leading-tight mb-4">
                    備品管理を、もっとシンプルに。
                </h2>
                <p class="text-lg md:text-xl text-white/80 max-w-3xl mb-8">
                    EquipHubは、チーム内に散在する備品の予約・承認・管理といったプロセスを、一つの美しいインターフェースに統合する、スマート・ポータルです。
                </p>
                <a href="{{ route('register') }}"
                    class="bg-indigo-600 text-white font-semibold px-8 py-3 rounded-full hover:bg-indigo-700 transition-transform transform hover:scale-105 text-lg">
                    今すぐ無料でアカウント登録
                </a>
            </main>
        </div>
    </div>

    {{-- 特徴紹介セクション --}}
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold">EquipHubでできること</h3>
                <p class="text-gray-500 mt-3 text-lg">面倒な業務は、スマートなツールに任せよう。</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Feature 1 --}}
                <div class="text-center">
                    <div
                        class="bg-indigo-100 text-indigo-600 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-3">直感的な備品予約</h4>
                    <p class="text-gray-600 leading-relaxed">誰が、何を、いつまで使っているかが一目瞭然。数クリックで、必要な備品を簡単に予約・申請できます。</p>
                </div>
                {{-- Feature 2 --}}
                <div class="text-center">
                    <div
                        class="bg-indigo-100 text-indigo-600 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-3">柔軟な承認フロー</h4>
                    <p class="text-gray-600 leading-relaxed">申請内容は管理者に即座に通知。管理者は、いつでもどこでも、内容を確認して承認・却下のアクションを実行できます。</p>
                </div>
                {{-- Feature 3 --}}
                <div class="text-center">
                    <div
                        class="bg-indigo-100 text-indigo-600 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2a4 4 0 00-4-4H3a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004-4zm0 0v-2a4 4 0 014-4h2a4 4 0 014 4v2m-6 0h6m-6 0v-2a4 4 0 00-4-4H3a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004-4z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-semibold mb-3">リアルタイムな状況把握</h4>
                    <p class="text-gray-600 leading-relaxed">ダッシュボードでは、現在の貸出状況や、承認待ちの件数をリアルタイムに可視化。資産の稼働状況を正確に把握できます。
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- フッター --}}
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} EquipHub. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>
