<?php

namespace Database\Seeders;

use App\Models\ApprovalFlow;
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
            'is_admin' => true,
        ]);
        User::factory(20)->create();



        // ----- 2. 現在の備品状況（確定済みデータ）の作成 -----
        $this->command->info('Seeding current equipments & reservations...');
        Equipment::factory(50)->create();
        Reservation::factory(100)->create(); // 過去の貸出履歴を100件作成

        

        // ----- 3. 備品登録申請（承認待ち）のダミーデータ作成 -----
        $this->command->info('Seeding pending equipment-create requests...');
        ChangeRequest::factory(5)->make([ // make()でメモリ上にのみインスタンスを作成
            'target_model' => Equipment::class,
            'target_id' => null,
            'type' => 'create',
            'payload_before' => null,
            'payload_after' => fn() => Equipment::factory()->make()->toArray(),
        ])->each(function ($cr) {
            $cr->save(); // まずChangeRequestを保存
            ApprovalFlow::factory()->create([ // 次にそれに紐づく承認フローを作成
                'source_model' => ChangeRequest::class,
                'source_id' => $cr->id,
                'status' => 10, // 承認待ち
            ]);
        });
        
        // ----- 4. 備品編集申請（承認済み）のダミーデータ作成 -----
        $this->command->info('Seeding approved equipment-update requests...');
        $targetEquipment = Equipment::inRandomOrder()->first();
        ChangeRequest::factory(3)->make([
            'target_model' => Equipment::class,
            'target_id' => $targetEquipment->id,
            'type' => 'update',
            'payload_before' => ['status' => $targetEquipment->status],
            'payload_after' => ['status' => 30], // 修理中(30)にする申請
        ])->each(function ($cr) {
            $cr->save();
            ApprovalFlow::factory()->approved()->create([ // 承認済みの状態
                'source_model' => ChangeRequest::class,
                'source_id' => $cr->id,
            ]);
        });
    }
}