<?php

namespace Database\Seeders;

use App\Models\ApprovalFlow;
use App\Models\Category;
use App\Models\Division;
use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ★追加: トランザクションのためにインポート

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ----------------------------------------------------------------
        // ① 依存関係のないマスタデータを作成 (外部キーをもたない)
        // ----------------------------------------------------------------
        $this->command->info('Seeding master data...');

        Division::factory(7)->create();
        Category::factory(7)->create();


        // ----------------------------------------------------------------
        // ② ユーザーを作成　（division_idは外部キー）
        // ----------------------------------------------------------------
        $this->command->info('Seeding users...');

        // 1. まずは、必ず存在する管理者ユーザーを1名作成する
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        // 2. 一般ユーザーを20名作成する
        User::factory(20)->create();


        // ----------------------------------------------------------------
        // ③ 備品を作成　(category_idとdivision_idは外部キー)
        // ----------------------------------------------------------------
        $this->command->info('Seeding equipments...');

        Equipment::factory(50)->create();


        // ----------------------------------------------------------------
        // ④ 予約と、それに紐づく承認フローを作成
        // ----------------------------------------------------------------
        $this->command->info('Seeding reservations and approval flows...');

        // 30件の予約を作成
        Reservation::factory(30)->create()->each(function ($reservation) {
            // ★ポリモーフィックリレーションのSeeding！
            // 作成された予約($reservation)一件ごとに、
            // それに紐づくApprovalFlowを1件作成する
            ApprovalFlow::factory()->create([
                'source_model' => Reservation::class, // どのモデルか
                'source_id' => $reservation->id,      // そのモデルのどのIDか
            ]);
        });
    }
}
