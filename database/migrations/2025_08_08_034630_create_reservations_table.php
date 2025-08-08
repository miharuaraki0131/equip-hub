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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // 外部キー
            $table->foreignId('user_id')->constrained('users'); // ユーザID
            $table->foreignId('equipment_id')->constrained('equipments'); //

            $table->date('start_date'); // 予約開始日
            $table->date('end_date');   // 予約終了日
            $table->integer('status')->default(10)->comment('10:申請中, 20:承認済, 30:貸出中, 40:返却済, 90:却下');

            $table->dateTime('rented_at')->nullable(); //実際に貸出された日時 (最初はnull)
            $table->dateTime('returned_at')->nullable(); // 実際に返却された日時 (最初はnull)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
