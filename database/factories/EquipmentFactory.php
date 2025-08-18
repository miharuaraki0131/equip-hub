<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 備品名のサンプルを用意
        $pcNames = ['Let\'s Note CF-SV8', 'MacBook Pro 14 inch', 'Surface Laptop 5', 'ThinkPad X1 Carbon', 'Lenovo ThinkPad X1 Carbon','MSI', ];
        $monitorNames = ['Dell 24 inch Monitor', 'EIZO FlexScan 27 inch', 'LG UltraWide 34 inch', 'Samsung 32 inch', 'ASUS 27 inch', 'MSI', ];

        // 状態（status）のサンプルを用意（設計書の定義通り）
        $statuses = [10, 20, 30, 99]; // 10:利用可, 20:貸出中, 30:修理中, 99:廃棄済

        return [
            // nameはPC名かモニター名をランダムに選ぶ
            'name' => $this->faker->randomElement(array_merge($pcNames, $monitorNames)),

            'description' => $this->faker->realText(100),

            // image_pathは今のところ空で良いのでnull
            'image_path' => null,

            // statusは配列からランダムに選ぶ
            'status' => $this->faker->randomElement($statuses),

            // 外部キーは、既に存在する親テーブルのIDからランダムに取得する
            'category_id' => Category::inRandomOrder()->first()->id,
            'division_id' => Division::inRandomOrder()->first()->id,
        ];
    }
}
