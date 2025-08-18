<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 部署名のサンプルを用意
        $divisions = ['総務部', '経理部', '人事部', '営業第一部', '営業第二部', '開発部', 'マーケティング部', '財務部', '企画部', 'システム部'];

        return [
            // unique() を使って、生成されるデータが重複しないようにする
            // randomElement() で配列からランダムに一つ選ぶ
            'name' => $this->faker->unique()->randomElement($divisions),
        ];
    }
}
