<?php

namespace Tests\Feature\Equipment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Division;
use App\Models\Category;
use App\Models\Equipment;
use PHPUnit\Framework\Attributes\Test;

class EquipmentManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;
    private Division $division;

    // 共通の準備処理
    protected function setUp(): void
    {
        parent::setUp();
        $this->division = Division::factory()->create();
        $this->category = Category::factory()->create();
        // 管理者ユーザーをプロパティに保持しておくことで、各テストで使い回せる
        $this->admin = User::factory()->create(['is_admin' => 1]);
    }

    #[Test]
    public function 管理者は新しい備品を登録できる(): void
    {
        // 1. 準備 (Arrange)
        // フォームで送信されるであろう、新しい備品のデータ
        $equipmentData = [
            'name' => '新品のプロジェクター',
            'category_id' => $this->category->id,
            'division_id' => $this->division->id,
            'description' => 'これはテスト用の備品です。',
        ];

        // 2. 実行 (Act)
        // 管理者としてログインし、備品登録のエンドポイントにPOSTリクエストを送信
        $response = $this->actingAs($this->admin)->post(route('equipments.store'), $equipmentData);

        // 3. 検証 (Assert)
        // A. 備品一覧ページにリダイレクトされたことを確認
        $response->assertRedirect(route('equipments.index'));

        // B. データベースのequipmentsテーブルに、送信したデータが正しく保存されていることを確認
        $this->assertDatabaseHas('equipments', [
            'name' => '新品のプロジェクター',
            'description' => 'これはテスト用の備品です。',
        ]);
    }

    #[Test]
    public function 管理者は既存の備品情報を更新できる(): void
    {
        // 1. 準備 (Arrange)
        // 更新対象となる、既存の備品を1件作成
        $equipment = Equipment::factory()->create();
        // 更新用の新しいデータ
        $updateData = [
            'name' => '更新されたプロジェクター名',
            'category_id' => $this->category->id,
            'division_id' => $this->division->id,
            'description' => '説明文も更新されました。',
        ];

        // 2. 実行 (Act)
        // 管理者としてログインし、更新処理のエンドポイントにPUTリクエストを送信
        $response = $this->actingAs($this->admin)->put(route('equipments.update', $equipment), $updateData);

        // 3. 検証 (Assert)
        $response->assertRedirect(route('equipments.index'));
        // データベースのレコードが、更新後のデータになっていることを確認
        $this->assertDatabaseHas('equipments', [
            'id' => $equipment->id,
            'name' => '更新されたプロジェクター名',
        ]);
    }

    #[Test]
    public function 管理者は備品を論理削除できる(): void
    {
        // 1. 準備 (Arrange)
        // 削除対象となる、既存の備品を1件作成
        $equipment = Equipment::factory()->create();

        // 2. 実行 (Act)
        // 管理者としてログインし、削除処理のエンドポイントにDELETEリクエストを送信
        $response = $this->actingAs($this->admin)->delete(route('equipments.destroy', $equipment));

        // 3. 検証 (Assert)
        $response->assertRedirect(route('equipments.index'));
        // equipmentsテーブルから、指定した備品が「論理削除」されていることを確認
        $this->assertSoftDeleted('equipments', [
            'id' => $equipment->id,
        ]);
    }
}
