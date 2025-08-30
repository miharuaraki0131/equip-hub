<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Category;
use App\Models\Division;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // 親のsetUpを必ず呼び出す

        // 全てのFeatureテストの前に、最低1つの部署とカテゴリが存在する状態を保証する
        Division::factory()->create();
        Category::factory()->create();
    }
}
