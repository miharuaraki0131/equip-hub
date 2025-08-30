<x-portal-layout :showHero="true" heroTitle="備品の新規登録" heroSubtitle="新しい備品情報をシステムに登録します。">

    <div class="bg-[var(--card-bg)] p-6 md:p-8 rounded-xl shadow-md max-w-2xl mx-auto">

        <form action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data"> {{-- ★enctypeを追加 --}}
            @csrf

            <div class="space-y-6">

                {{-- 備品名 --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">備品名 <span
                            class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="例：MacBook Pro 14 inch">
                    </div>
                </div>

                {{-- カテゴリ --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">カテゴリ <span
                            class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select id="category_id" name="category_id" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">選択してください</option>
                            <option value="1">ノートPC</option>
                            <option value="2">モニター</option>
                            <option value="3">キーボード</option>
                        </select>
                    </div>
                </div>

                {{-- 管理部署 --}}
                <div>
                    <label for="division_id" class="block text-sm font-medium text-gray-700">管理部署</label>
                    <div class="mt-1">
                        <select id="division_id" name="division_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">選択してください</option>
                            <option value="1">総務部</option>
                            <option value="6">開発部</option>
                        </select>
                    </div>
                </div>

                {{-- 詳細説明 --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">詳細説明</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="4"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="スペック、注意事項などを入力"></textarea>
                    </div>
                </div>

                {{-- 画像アップロード --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">備品画像</label>
                    <div class="mt-1">
                        <input type="file" name="image" id="image"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

            </div>

            {{-- 登録ボタン --}}
            <div class="mt-8 pt-5 border-t border-gray-200">
                <div class="flex justify-end">
                    <a href="{{ route('equipments.index') }}" class="btn-secondary mr-4">
                        キャンセル
                    </a>
                    <button type="submit" class="btn-primary">
                        登録する
                    </button>
                </div>
            </div>

        </form>

    </div>

</x-portal-layout>
