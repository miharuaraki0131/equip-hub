<x-portal-layout :showHero="true" heroTitle="備品の編集" heroSubtitle="ID: {{ $equipment->id }} の備品情報を編集します。">

    <div class="bg-[var(--card-bg)] p-6 md:p-8 rounded-xl shadow-md max-w-2xl mx-auto">

        <form action="{{ route('equipments.update', $equipment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                {{-- 備品名 --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">備品名 <span
                            class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" required
                            value="{{ old('name', $equipment->name) }}"
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
                            <option value="1" @selected(old('category_id', $equipment->category_id) == 1)>ノートPC</option>
                            <option value="2" @selected(old('category_id', $equipment->category_id) == 2)>モニター</option>
                            <option value="3" @selected(old('category_id', $equipment->category_id) == 3)>キーボード</option>
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
                            <option value="1" @selected(old('division_id', $equipment->division_id) == 1)>総務部</option>
                            <option value="6" @selected(old('division_id', $equipment->division_id) == 6)>開発部</option>
                        </select>
                    </div>
                </div>

                {{-- 詳細説明 --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">詳細説明</label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="4"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="スペック、注意事項などを入力">
                            {{ old('description', $equipment->description) }}
                        </textarea>
                    </div>
                </div>

                {{-- 画像アップロード --}}
                <div>
                    <label ...>備品画像</label>
                    @if ($equipment->image_path)
                        <div class="my-2">
                            <img src="{{ asset('storage/' . $equipment->image_path) }}" alt="現在の画像"
                                class="max-w-xs rounded">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="...">
                    <p class="text-xs text-gray-500 mt-1">新しい画像をアップロードすると、既存の画像は上書きされます。</p>
                </div>

            </div>

            {{-- 更新ボタン --}}

            <button type="submit" class="btn-primary">
                更新する
            </button>
    </div>

    </form>

    </div>

</x-portal-layout>
