<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Division;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\ChangeRequest;
use App\Models\Reservation;
use PHPUnit\Framework\Attributes\Test;

class AdminActionTest extends TestCase
{
    use RefreshDatabase;

    // 共通の準備処理
    protected function setUp(): void
    {
        parent::setUp();
        Division::factory()->create();
        Category::factory()->create();
    }

    #[Test]
    public function 一般ユーザーは申請を承認できない(): void
    {
        // 1. 準備 (Arrange)
        // 一般ユーザーと、承認待ちの申請を1件作成する
        $generalUser = User::factory()->create(['is_admin' => 0]);
        $equipment = Equipment::factory()->create();
        $changeRequest = ChangeRequest::factory()->create([
            'target_model' => Equipment::class,
            'target_id' => $equipment->id,
            'status' => 10, // 10: 承認待ち
            'type' => 'create_reservation',
        ]);

        // 2. 実行 (Act)
        // 一般ユーザーとしてログインし、承認処理のURLに直接POSTリクエストを送信する
        $response = $this->actingAs($generalUser)
            ->post(route('admin.approvals.approve', $changeRequest));

        // 3. 検証 (Assert)
        // A. アクセスが拒否された(403 Forbidden)ことを確認
        $response->assertForbidden();

        // B. データベースの申請ステータスが「承認待ち」のままであることを確認
        //    fresh()メソッドで、DBから最新の状態を再取得してチェックする
        $this->assertEquals(10, $changeRequest->fresh()->status);
    }

    #[Test]
    public function 一般ユーザーは備品を貸出実行できない(): void
    {
        // 1. 準備 (Arrange)
        // 一般ユーザーと、承認済み(貸出待ち)の予約を1件作成する
        $generalUser = User::factory()->create(['is_admin' => 0]);
        $equipment = Equipment::factory()->create();
        $reservation = Reservation::factory()->create([
            'equipment_id' => $equipment->id,
            'status' => 20, // 20: 承認済(貸出待)
        ]);

        // 2. 実行 (Act)
        // 一般ユーザーとしてログインし、貸出実行のURLに直接POSTリクエストを送信する
        $response = $this->actingAs($generalUser)
            ->post(route('admin.reservations.lend', $reservation));

        // 3. 検証 (Assert)
        // A. アクセスが拒否された(403 Forbidden)ことを確認
        $response->assertForbidden();

        // B. データベースの予約ステータスが「承認済(貸出待)」のままであることを確認
        $this->assertEquals(20, $reservation->fresh()->status);
    }
}
