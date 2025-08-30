<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase; // LaravelのTestCaseではなく、PHPUnitの基本的なTestCaseを継承
use App\Models\ChangeRequest;
use PHPUnit\Framework\Attributes\Test;

class ChangeRequestModelTest extends TestCase
{
    #[Test]
    public function statusが10の場合に承認待ちバッジを返すこと(): void
    {
        // 1. 準備 (Arrange)
        // データベースは使わない。ただのPHPオブジェクトとして、モデルのインスタンスを作成する
        $changeRequest = new ChangeRequest();
        $changeRequest->status = 10; // statusプロパティに、直接値を設定

        // 2. 実行 (Act)
        // テスト対象のアクセサ（status_badge）を呼び出す
        $badge = $changeRequest->status_badge;

        // 3. 検証 (Assert)
        // 実行結果（返ってきたHTML文字列）が、期待通りの値を含んでいるかを確認する
        $this->assertStringContainsString('承認待ち', $badge);
        $this->assertStringContainsString('bg-yellow-100', $badge);
    }

    #[Test]
    public function statusが20の場合に承認済みバッジを返すこと(): void
    {
        // 1. 準備
        $changeRequest = new ChangeRequest();
        $changeRequest->status = 20;

        // 2. 実行
        $badge = $changeRequest->status_badge;

        // 3. 検証
        $this->assertStringContainsString('承認済み', $badge);
        $this->assertStringContainsString('bg-green-100', $badge);
    }

    #[Test]
    public function statusが30の場合に却下バッジを返すこと(): void
    {
        // 1. 準備
        $changeRequest = new ChangeRequest();
        $changeRequest->status = 30;

        // 2. 実行
        $badge = $changeRequest->status_badge;

        // 3. 検証
        $this->assertStringContainsString('却下', $badge);
        $this->assertStringContainsString('bg-red-100', $badge);
    }

    #[Test]
    public function statusが想定外の値の場合に不明バッジを返すこと(): void
    {
        // 1. 準備
        $changeRequest = new ChangeRequest();
        $changeRequest->status = 99; // 想定外の値

        // 2. 実行
        $badge = $changeRequest->status_badge;

        // 3. 検証
        $this->assertStringContainsString('不明', $badge);
        $this->assertStringContainsString('bg-gray-100', $badge);
    }
}
