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
        Schema::create('approval_flows', function (Blueprint $table) {
            $table->id();

            // 汎用的に使えるように
            $table->string('source_model'); // 例: 'App\Models\Reservation'
            $table->unsignedBigInteger('source_id');

            // 外部キー
            $table->foreignId('approver_id')->constrained('users');

            $table->integer('status')->default(10)->comment('10:承認待ち, 20:承認済, 30:差戻し/却下');
            $table->text('comment')->nullable();
            $table->dateTime('processed_at')->nullable();

            $table->timestamps();

            // 複合インデックス (パフォーマンス向上のため)
            $table->index(['source_model', 'source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_flows');
    }
};
