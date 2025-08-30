<?php

namespace Tests\Feature\Reservation;

// 必要なモデルやクラスをuseで宣言します
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Division;
use App\Models\Category;
use App\Models\Equipment;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Reservation;

class ReservationRequestTest extends TestCase // Pestではなくクラス形式で書きますね
{
    use RefreshDatabase; // 各テストの前にDBをリフレッシュする魔法

    // テスト全体で使う、共通の準備処理をまとめる便利なメソッド
    protected function setUp(): void
    {
        parent::setUp(); // 親クラスのsetUpを必ず呼び出す

        // [修正] 各テストの前に、必ず部署とカテゴリを作成しておく
        Division::factory()->create();
        Category::factory()->create();
    }


    #[Test]
    public function ログインユーザーは備品の予約申請ができる(): void
    {
        // 準備
        $user = User::factory()->create();
        $equipment = Equipment::factory()->create();
        $reservationData = [
            'equipment_id' => $equipment->id,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDay()->format('Y-m-d'),
        ];

        // 実行
        $response = $this->actingAs($user)->post(route('reservations.store'), $reservationData);

        // 検証
        $response->assertRedirect(route('my.reservations.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('change_requests', 1);
        $this->assertDatabaseHas('change_requests', [
            'user_id' => $user->id,
            'target_id' => $equipment->id,
        ]);
    }

    #[Test]
    public function 予約申請時_開始日が空の場合はバリデーションエラーとなる(): void
    {
        // 準備
        $user = User::factory()->create();
        $equipment = Equipment::factory()->create();
        $invalidData = [
            'equipment_id' => $equipment->id,
            'start_date' => '', // 不正なデータ
            'end_date' => now()->addDay()->format('Y-m-d'),
        ];

        // 実行
        $response = $this->actingAs($user)->post(route('reservations.store'), $invalidData);

        // 検証
        $response->assertSessionHasErrors('start_date');
        $this->assertDatabaseCount('change_requests', 0);
    }


    #[Test]
    public function 予約申請時_終了日が開始日より前の場合はバリデーションエラーとなる(): void
    {
        // 準備
        $user = User::factory()->create();
        $equipment = Equipment::factory()->create();
        $invalidData = [
            'equipment_id' => $equipment->id,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->subDay()->format('Y-m-d'), // 不正なデータ
        ];

        // 実行
        $response = $this->actingAs($user)->post(route('reservations.store'), $invalidData);

        // 検証
        $response->assertSessionHasErrors('end_date');
        $this->assertDatabaseCount('change_requests', 0);
    }

    #[Test]
    public function 予約申請時_他の予約と期間が重複する場合はバリデーションエラーとなる(): void
    {
        // 1. 準備 (Arrange)
        // 登場人物を準備する
        $userA = User::factory()->create(); // 予約を申請するユーザー
        $userB = User::factory()->create(); // すでに予約済みのユーザー
        $equipment = Equipment::factory()->create();

        // userBが、来週の月曜日から水曜日まで、備品を予約している、という「過去の事実」を作成する
        Reservation::factory()->create([
            'user_id' => $userB->id,
            'equipment_id' => $equipment->id,
            'start_date' => now()->addWeek()->startOfWeek(), // 来週の月曜日
            'end_date' => now()->addWeek()->startOfWeek()->addDays(2), // 来週の水曜日
            'status' => 30, // 貸出中（承認済みでもOK）
        ]);

        // userAが、その期間に重なるように、来週の火曜日から木曜日まで予約しようとする
        $overlappingData = [
            'equipment_id' => $equipment->id,
            'start_date' => now()->addWeek()->startOfWeek()->addDay(), // 来週の火曜日
            'end_date' => now()->addWeek()->startOfWeek()->addDays(3), // 来週の木曜日
        ];

        // 2. 実行 (Act)
        // userAとしてログインし、重複するデータで予約申請をPOSTする
        $response = $this->actingAs($userA)->post(route('reservations.store'), $overlappingData);

        // 3. 検証 (Assert)
        // A. レスポンスに、いずれかの日付に関するバリデーションエラーが含まれていることを確認
        //    (カスタムルールでは、複数のフィールドにエラーを返すことがあるため、'start_date'か'end_date'のどちらか、
        //     あるいは両方にエラーがあればOKとします。ここでは'start_date'を代表でチェックします)
        $response->assertSessionHasErrors('start_date');

        // B. データベースに、新しい申請レコードが作成されていないことを確認
        $this->assertDatabaseCount('change_requests', 0);
    }
}
