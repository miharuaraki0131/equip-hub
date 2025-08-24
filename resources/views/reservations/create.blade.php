<x-portal-layout :showHero="true" heroTitle="備品の予約" heroSubtitle="備品を予約します">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">申請対象の備品</h3>
                    <p>備品名: {{ $equipment->name }}</p>
                    <p class="mb-7">説明: {{ $equipment->description }}</p>

                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf

                        {{-- 申請する備品のIDを隠しフィールドとして送信 --}}
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

                        <div class="space-y-6">
                            {{-- 貸出期間 --}}
                            <div>
                                <h4 class="text-md font-semibold mb-2 border-b pb-1">貸出期間</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    {{-- 開始日 --}}
                                    <div>
                                        <label for="start_date"
                                            class="block font-medium text-sm text-gray-700">貸出開始日</label>
                                        <input type="date" id="start_date" name="start_date"
                                            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            required
                                            value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- 終了日 --}}
                                    <div>
                                        <label for="end_date"
                                            class="block font-medium text-sm text-gray-700">貸出終了日</label>
                                        <input type="date" id="end_date" name="end_date"
                                            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            required
                                            value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- フォームの送信ボタン --}}
                        <div class="flex items-center justify-end mt-8">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border hover:bg-blue-600 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                この内容で申請する
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-portal-layout>
