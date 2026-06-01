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
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->boolean('no_middle_name')->nullable()->after('middle_name');
            $table->boolean('no_extension_name')->nullable()->after('extension_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->dropColumn(['no_middle_name', 'no_extension_name']);
        });
    }
};
