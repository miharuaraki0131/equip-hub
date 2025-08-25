{{-- show.blade.php の骨格イメージ --}}
<x-portal-layout>
    <h1 class="text-2xl font-bold">申請詳細 (ID: {{ $change_request->id }})</h1>

    {{-- 申請者情報のセクション --}}
    <div class="mt-6">
        <h2 class="text-lg font-semibold">申請者</h2>
        <p>氏名: {{ $change_request->user->name }}</p>
        {{-- <p>部署: {{ $change_request->user->division->name }}</p> --}}
    </div>

    {{-- 申請内容のセクション --}}
    <div class="mt-6">
        <h2 class="text-lg font-semibold">申請内容</h2>
        <p>対象備品: {{ $change_request->targetable->name }}</p>
        @php
            $payload = json_decode($change_request->payload_after, true);
        @endphp
        <p>希望期間: {{ $payload['start_date'] }} から {{ $payload['end_date'] }} まで</p>
    </div>

    {{-- 承認・却下アクションのセクション --}}
    <div class="mt-8 flex gap-4">
        {{-- 承認フォーム --}}
        <form action="..." method="POST">
            @csrf
            <button type="submit" class="btn-primary">承認する</button>
        </form>

        {{-- 却下フォーム --}}
        <form action="..." method="POST">
            @csrf
            <button type="submit" class="btn-secondary">却下する</button>
        </form>
    </div>
</x-portal-layout>