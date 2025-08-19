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
        // 予約期間を過去の日付でランダムに生成
        $startDate = Carbon::instance($this->faker->dateTimeBetween('-1 year', '-1 week'));
        $endDate = (clone $startDate)->addDays($this->faker->numberBetween(1, 14));

        // 状態（status）のサンプル
        $statuses = [30, 40]; //  30:貸出中, 40:返却済

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'equipment_id' => Equipment::inRandomOrder()->first()->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'status' => $this->faker->randomElement($statuses),

            // statusに応じて、貸出・返却日時を設定
            'rented_at' => $startDate->addHours($this->faker->numberBetween(9, 17)),
            'returned_at' => $this->faker->randomElement([
                null, // 貸出中の場合はnull
                (clone $endDate)->addHours($this->faker->numberBetween(9, 17))
            ]),
        ];
    }
}
