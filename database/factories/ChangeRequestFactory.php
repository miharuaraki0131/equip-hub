<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChangeRequest>
 */
class ChangeRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 申請者は、管理者ではない一般ユーザーからランダムに選ぶ
            'user_id' => User::where('is_admin', false)->inRandomOrder()->first()->id,
        ];
    }
}