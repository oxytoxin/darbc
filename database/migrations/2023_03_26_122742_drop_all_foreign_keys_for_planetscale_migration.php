<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::table('clusters', function (Blueprint $table) {
            $table->dropForeign(['leader_id']);
        });
        Schema::table('member_information', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['cluster_id']);
            $table->dropForeign(['original_member_id']);
            $table->dropForeign(['gender_id']);
            $table->dropForeign(['membership_status_id']);
            $table->dropForeign(['occupation_id']);
        });
        Schema::table('restrictions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('dividends', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['release_id']);
            $table->dropForeign(['released_by']);
        });
        Schema::table('land_recordings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('free_lots', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['cluster_id']);
        });
        Schema::table('cash_advances', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('daily_cashes', function (Blueprint $table) {
            $table->dropForeign(['cashier_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
