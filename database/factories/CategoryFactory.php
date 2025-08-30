<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 備品カテゴリのサンプルを用意
        $categories = ['ノートPC', 'モニター', 'キーボード', 'マウス', 'Webカメラ', 'ソフトウェアライセンス', '書籍','CD/DVD'];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
