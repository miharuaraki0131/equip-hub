<x-portal-layout :showHero="true" :showHeroButtons="true" heroTitle="備品をスマートに管理" heroSubtitle="必要な備品をいつでも、どこからでも。EquipHubがあなたの仕事をサポートします。">

    {{-- =============================================== --}}
    {{-- メイングリッド --}}
    {{-- =============================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">

        {{-- 左側（メインコンテンツ） --}}
        <div class="lg:col-span-3 space-y-6 lg:space-y-8">

            {{-- サマリーカードエリア --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                {{-- 承認待ちカード --}}
                <div class="bg-[var(--card-bg)] p-6 rounded-xl shadow-md flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="bg-yellow-100 p-3 rounded-full flex-shrink-0">
                        <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-[var(--text-dark)]">承認待ち</h3>
                        <p class="text-2xl lg:text-3xl font-black text-[var(--primary-color)]">3件</p>
                    </div>
                </div>

                {{-- 貸出中カード --}}
                <div class="bg-[var(--card-bg)] p-6 rounded-xl shadow-md flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="bg-blue-100 p-3 rounded-full flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-[var(--text-dark)]">貸出中</h3>
                        <p class="text-2xl lg:text-3xl font-black text-[var(--primary-color)]">5件</p>
                    </div>
                </div>

                {{-- 利用可能カード --}}
                <div class="bg-[var(--card-bg)] p-6 rounded-xl shadow-md flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="bg-green-100 p-3 rounded-full flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-[var(--text-dark)]">利用可能</h3>
                        <p class="text-2xl lg:text-3xl font-black text-[var(--primary-color)]">42件</p>
                    </div>
                </div>
            </div>

            {{-- 貸出中備品エリア --}}
            <div>
                <h2 class="text-xl lg:text-2xl font-bold mb-4 flex items-center gap-2">
                    <svg class="h-6 w-6 text-[var(--primary-color)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    現在貸出中の備品
                </h2>
                <div class="bg-[var(--card-bg)]/50 border-2 border-dashed border-[var(--border-color)] rounded-xl p-8 lg:p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-[var(--text-light)] mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5c0-.621.504-1.125 1.125-1.125H6.75m10.5 1.5h-4.5V3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v1.5m-10.5 0a3.375 3.375 0 003.375 3.375h1.5a3.375 3.375 0 003.375-3.375" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-[var(--text-dark)] mb-2">現在、貸出中の備品はありません</h3>
                    <p class="text-sm text-[var(--text-light)] mb-6">新しいツールを探しに行きませんか？</p>
                    <a class="btn-primary inline-flex" href="#">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        備品一覧へ
                    </a>
                </div>
            </div>

        </div>

        {{-- 右側（サイドバー） --}}
        <aside class="space-y-6 lg:space-y-8">
            <div class="bg-[var(--card-bg)] p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-[var(--primary-color)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    利用状況サマリー
                </h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-bold text-sm mb-2 text-[var(--text-dark)]">カテゴリ別貸出比率</h4>
                        <div class="h-32">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm mb-2 text-[var(--text-dark)]">月別貸出トレンド</h4>
                        <div class="h-32">
                            <canvas id="monthlyTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- クイックアクション --}}
            <div class="bg-[var(--card-bg)] p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-[var(--primary-color)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    クイックアクション
                </h3>
                <div class="space-y-3">
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                        <div class="bg-blue-100 p-2 rounded-lg group-hover:bg-blue-200 transition-colors">
                            <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[var(--text-dark)]">新規予約</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                        <div class="bg-green-100 p-2 rounded-lg group-hover:bg-green-200 transition-colors">
                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[var(--text-dark)]">承認処理</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                        <div class="bg-purple-100 p-2 rounded-lg group-hover:bg-purple-200 transition-colors">
                            <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-[var(--text-dark)]">レポート確認</span>
                    </a>
                </div>
            </div>
        </aside>

    </div>

    {{-- =============================================== --}}
    {{-- ページ固有のJavaScript --}}
    {{-- =============================================== --}}
    @push('scripts')
    <script>
        // Chart.jsの完全に安全な初期化
        function waitForChart() {
            return new Promise((resolve, reject) => {
                let attempts = 0;
                const maxAttempts = 50; // 5秒間試行

                function checkChart() {
                    attempts++;
                    
                    if (typeof Chart !== 'undefined' && Chart.register) {
                        console.log('Chart.js loaded successfully');
                        resolve();
                    } else if (attempts >= maxAttempts) {
                        console.error('Chart.js failed to load after maximum attempts');
                        reject(new Error('Chart.js loading timeout'));
                    } else {
                        setTimeout(checkChart, 100);
                    }
                }
                
                checkChart();
            });
        }

        async function initializeCharts() {
            try {
                // Chart.jsの読み込み完了を待つ
                await waitForChart();

                const commonOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            bodyFont: { family: 'Noto Sans JP' },
                            titleFont: { family: 'Noto Sans JP' },
                        },
                    },
                };

                // 月別貸出トレンドグラフ
                const monthlyTrendElement = document.getElementById('monthlyTrendChart');
                if (monthlyTrendElement) {
                    const monthlyTrendCtx = monthlyTrendElement.getContext('2d');
                    if (monthlyTrendCtx) {
                        new Chart(monthlyTrendCtx, {
                            type: 'line',
                            data: {
                                labels: ['1月', '2月', '3月', '4月', '5月', '6月'],
                                datasets: [{
                                    label: '貸出件数',
                                    data: [12, 19, 15, 25, 22, 30],
                                    borderColor: '#0d7ff2',
                                    backgroundColor: 'rgba(13, 127, 242, 0.1)',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4,
                                }],
                            },
                            options: {
                                ...commonOptions,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        display: false,
                                    },
                                    x: {
                                        display: false,
                                    },
                                },
                            },
                        });
                        console.log('Monthly trend chart initialized');
                    }
                }

                // カテゴリ別貸出比率グラフ
                const categoryElement = document.getElementById('categoryChart');
                if (categoryElement) {
                    const categoryCtx = categoryElement.getContext('2d');
                    if (categoryCtx) {
                        new Chart(categoryCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['PC', 'モニター', 'その他'],
                                datasets: [{
                                    data: [40, 35, 25],
                                    backgroundColor: [
                                        '#0d7ff2',
                                        '#10b981',
                                        '#f59e0b',
                                    ],
                                    borderWidth: 0,
                                }],
                            },
                            options: {
                                ...commonOptions,
                                cutout: '60%',
                            },
                        });
                        console.log('Category chart initialized');
                    }
                }

            } catch (error) {
                console.error('Chart initialization failed:', error);
                // Chart.jsが使えない場合の代替表示
                const fallbackElements = document.querySelectorAll('#monthlyTrendChart, #categoryChart');
                fallbackElements.forEach(element => {
                    if (element) {
                        element.parentElement.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">グラフを読み込めませんでした</p>';
                    }
                });
            }
        }

        // DOM読み込み完了後に初期化
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCharts);
        } else {
            // 少し遅延させてChart.jsの読み込みを確実に待つ
            setTimeout(initializeCharts, 100);
        }
    </script>
    @endpush

</x-portal-layout>