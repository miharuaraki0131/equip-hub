<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon; // ★追加: 日付操作のためにCarbonをインポート

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 予約期間をランダムに生成
        $startDate = Carbon::instance($this->faker->dateTimeBetween('-1 month', '+1 month'));
        $endDate = (clone $startDate)->addDays($this->faker->numberBetween(1, 14));

        // 状態（status）のサンプル
        $statuses = [10, 20, 30, 40, 90]; // 10:申請中, 20:承認済, 30:貸出中, 40:返却済, 90:却下

        return [
            // 外部キーは、既存のUserとEquipmentからランダムに取得
            'user_id' => User::inRandomOrder()->first()->id,
            'equipment_id' => Equipment::inRandomOrder()->first()->id,

            'start_date' => $startDate->toDateString(), // Y-m-d 形式
            'end_date' => $endDate->toDateString(),     // Y-m-d 形式

            'status' => $this->faker->randomElement($statuses),
            'rented_at' => null,
            'returned_at' => null,
        ];
    }
}
