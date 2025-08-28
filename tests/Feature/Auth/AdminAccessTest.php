<?php

use App\Models\Division;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

// RefreshDatabaseを有効かする
uses(RefreshDatabase::class);

test('一般ユーザーは管理者ページにアクセスできない', function () {

    // 1. 準備

    // 部署を作成
    Division::factory()->create();

    // 一般ユーザーを作成
    $user = User::factory()->create([
        'is_admin' => 0
    ]);

    // 2. 実行 (Act) & 3. 検証 (Assert)
    // 作成した一般ユーザーとしてログインし、/admin/users ページにアクセスを試みたら、
    // 403 Forbidden（アクセス拒否）が返ってくることを期待する
    $this->actingAs($user)->get('/admin/users')->assertForbidden();
});

test('管理者ユーザーは管理者ページにアクセスできる', function () {

    // 1. 準備

    // 部署を作成
    Division::factory()->create();

    // 管理者ユーザーを作成
    $user = User::factory()->create([
        'is_admin' => 1
    ]);

    // 2. 実行 (Act) & 3. 検証 (Assert)
    // 作成した管理者ユーザーとしてログインし、/admin/users ページにアクセスを試みたら、
    // 200 OK（成功）が返ってくることを期待する
    $this->actingAs($user)->get('/admin/users')->assertOk();
});
