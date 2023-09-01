<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *`
     * @return void
     */
    public function up()
    {
        Schema::table('member_information', function (Blueprint $table) {
            $table->integer('dependents_count')->virtualAs('JSON_LENGTH(children) + IF(spouse IS NOT NULL AND spouse <> "", 1, 0)')->after('children');
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
