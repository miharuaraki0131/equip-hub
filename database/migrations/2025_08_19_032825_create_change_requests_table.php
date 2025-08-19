<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();

            // 誰が申請したか
            $table->foreignId('user_id')->constrained('users');

            // 何を対象にしているか (ポリモーフィック)
            $table->string('target_model');
            $table->unsignedBigInteger('target_id')->nullable();

            // 何をしたいのか
            $table->string('type')->comment("create, update, delete");

            // 差分データ
            $table->json('payload_before')->nullable()->comment('変更前の差分データ');
            $table->json('payload_after')->nullable()->comment('変更後の差分データ');

            $table->timestamps();
            
            // インデックス
            $table->index(['target_model', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};