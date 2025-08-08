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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 機器の名前
            $table->text('description')->nullable(); // 機器の説明
            $table->string('image_path')->nullable(); // 機器画像の保存先パス
            $table->integer('status')->default(10)->comment('10:利用可, 20:貸出中, 30:修理中, 99:廃棄済'); // 機器の状態


            //外部キー
            $table->foreignId('category_id')->constrained('categories'); // 機器のカテゴリID
            $table->foreignId('division_id')->nullable()->constrained('divisions'); // 機器の所属部門ID

            $table->softDeletes(); // 論理削除用カラム
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
