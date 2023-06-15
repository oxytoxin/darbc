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
        Schema::table('member_information', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('date_of_birth')->virtualAs('TIMESTAMPDIFF(YEAR,date_of_birth,CURDATE())');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_information', function (Blueprint $table) {
            //
        });
    }
};
