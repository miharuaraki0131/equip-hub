<x-portal-layout :showHero="true" heroTitle="備品の予約" heroSubtitle="備品を予約します">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">申請対象の備品</h3>
                    <p>備品名: {{ $equipment->name }}</p>
                    <p>説明: {{ $equipment->description }}</p>

                    {{-- ここに後で予約期間などを入力するフォームを作成します --}}

                </div>
            </div>
        </div>
    </div>
</x-portal-layout>
