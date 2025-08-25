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
        Schema::table('change_requests', function (Blueprint $table) {
            // status カラムを追加
            // int型で、デフォルト値は10, コメントは'10:承認待ち, 20:承認済, 30:却下' payload_afterの後に追加
            $table->integer('status')->default(10)->after('payload_after')->comment('10:承認待ち, 20:承認済, 30:却下');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('change_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
