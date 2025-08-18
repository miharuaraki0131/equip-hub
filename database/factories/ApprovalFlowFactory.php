<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApprovalFlow>
 */
class ApprovalFlowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 状態（status）のサンプル
        $statuses = [10, 20, 30]; // 10:承認待ち, 20:承認済, 30:差戻し/却下

        return [
            // 承認者は、is_adminがtrueのユーザーからランダムに選ぶことにする
            // where('is_admin', true) で管理者ユーザーのみを絞り込む
            'approver_id' => User::where('is_admin', true)->inRandomOrder()->first()->id,

            // source_model と source_id は、Seeder側で動的に設定するため、ここでは定義しない

            'status' => $this->faker->randomElement($statuses),

            // statusが承認済or却下の場合のみコメントを入れる
            'comment' => $this->faker->randomElement([null, $this->faker->realText(50)]),
            'processed_at' => $this->faker->randomElement([null, now()]),
        ];
    }
}
