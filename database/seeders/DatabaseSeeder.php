<?php

namespace Database\Seeders;

// use App\Models\ApprovalFlow; // ← [削除] 不要になったuse文
use App\Models\Category;
use App\Models\ChangeRequest;
use App\Models\Division;
use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ----- 1. 基礎マスタとユーザーの作成 -----
        $this->command->info('Seeding master data & users...');
        Division::factory(7)->create();
        Category::factory(7)->create();
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'is_admin' => 1, // trueではなく1に修正
        ]);
        User::factory()->create([
            'name' => 'General User',
            'email' => 'user@example.com',
            'is_admin' => 0, // falseではなく0に修正
        ]);
        User::factory(18)->create(); // 残りのユーザーを作成


        // ----- 2. 現在の備品状況（確定済みデータ）の作成 -----
        $this->command->info('Seeding current equipments & reservations...');
        Equipment::factory(50)->create();
        Reservation::factory(100)->create();


        // ----- 3. 予約申請（承認待ち）のダミーデータ作成 -----
        $this->command->info('Seeding pending reservation requests...');
        // ユーザーと備品をランダムに選んで、5件の「承認待ち」予約申請を作成する
        for ($i = 0; $i < 5; $i++) {
            $user = User::inRandomOrder()->first();
            $equipment = Equipment::where('status', 10)->inRandomOrder()->first(); // 利用可能な備品から選ぶ

            if ($user && $equipment) {
                ChangeRequest::factory()->create([
                    'user_id' => $user->id,
                    'target_model' => Equipment::class,
                    'target_id' => $equipment->id,
                    'type' => 'create_reservation',
                    'status' => 10, // 10: 承認待ち
                    'payload_after' => json_encode([
                        'start_date' => now()->addDays(rand(1, 5))->format('Y-m-d'),
                        'end_date' => now()->addDays(rand(6, 10))->format('Y-m-d'),
                    ]),
                ]);
            }
        }
    }
}
