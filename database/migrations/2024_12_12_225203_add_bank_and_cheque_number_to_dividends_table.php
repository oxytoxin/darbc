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
        Schema::table('dividends', function (Blueprint $table) {
            $table->string('bank')->nullable()->default(null)->after('net_amount');
            $table->string('cheque_number')->nullable()->default(null)->after('net_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dividends', function (Blueprint $table) {
            $table->dropColumn('bank');
            $table->dropColumn('cheque_number');
        });
    }
};
